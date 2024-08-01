<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Session;
use League\ColorExtractor\Color;
use League\ColorExtractor\Palette;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Midtrans;
use setasign\Fpdi\Fpdi;
use App\Jobs\ColorDetect;
use Illuminate\Support\Facades\Redis;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware("printing");
    }
    
    public function colorStatus($id){
        $session = Session::where(["session" => $id])->first();
        sleep(1);
        if (!$session)
            return response()->json(["sucess" => false]);
        $folder = "../public/uploads/$id/";
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($folder."file.pdf");
        $coloredPage = [];
        $progress = @file_get_contents($folder."tmp.txt")+1;
        $status = (bool)@file_get_contents($folder."finish.txt");
        return response()->json(["sucess" => true, "done" => $status, "progress" => floor($progress/$pageCount*100)]);
    }
    
    private function totalPage($id)
    {
        $folder = "../public/uploads/$id";
        $pageCount = file_get_contents($folder."/tmp.txt")+1;
        $coloredPage = json_decode(file_get_contents($folder."/data.json"));
        return [$pageCount, count(array_unique($coloredPage))];

    }
    private function calculate($page_total, $page_colored, $bnw, $color)
    {
        return $color * $page_colored + (($page_total - $page_colored) * $bnw);
    }
    public function index($id)
    {
        $setting = Setting::first();
        $session = Session::where(["session" => $id])->first();
        if (!$session)
            return redirect("/");
        if ($session->status == 0 || $session->status == 1) {
            $session->status = 1;
            $session->touch();
            $session->save();
            return view("user.upload", ["id" => $id]);
        } else if ($session->status == 2) {
            $file = "../public/uploads/$id/finish.txt";
            if(file_exists($file)){
                $isFinish = file_get_contents($file);
                if($isFinish !== "1"){
                    sleep(1);
                    return view("user.wait");
                }
            }
            else{
                return view("user.wait");
            }
            [$page_total, $page_colored] = $this->totalPage($id);
            $bnw = $page_total * $setting->bnw;
            $colored = $this->calculate($page_total, $page_colored, $setting->bnw, $setting->colored);

            return view("user.view", [
                "id" => $id,
                "total" => $page_total,
                "total_colored" => $page_colored,
                "bnw" => $bnw,
                "colored" => $colored
            ]);
        } else if ($session->status == 3) {
            $trx = Transaction::where(["session_id" => $session->id])->first();
            return view("user.payment", [
                "qr" => $trx->qr,
                "amount" => $trx->amount,
            ]);
        }
    }

    public function payment(Request $request, $id)
    {

        $type = $request->input('type');
        $validator = Validator::make(["type" => $type], ["type" => "required|in:1,2"]);
        if ($validator->fails())
            return redirect("/print/$id");
        $setting = Setting::first();
        $session = Session::where(["session" => $id])->first();
        if (!$session)
            return redirect("/");
        [$page_total, $page_colored] = $this->totalPage($id);
        $bnw = $page_total * $setting->bnw;
        $colored = $this->calculate($page_total, $page_colored, $setting->bnw, $setting->colored);
        $price = $type == 1 ? $bnw : $colored;
        $midtrans = new Midtrans;
        $transaction = $midtrans->payment($price);
        $qr = $transaction['qr_string'];
        $transaction_id = $transaction['transaction_id'];
        Transaction::create([
            "session_id" => $session->id,
            "amount" => $price,
            "status" => 404,
            "qr" => $qr,
            "trx_uuid" => $transaction_id
        ]);

        $session->status = 3;
        $session->color = $type;
        $session->touch();
        $session->save();
        return redirect("/print/$id");

    }
    public function upload(Request $request, $id)
    {
        $session = Session::where(["session" => $id])->first();
        if (!$session)
            return redirect("/");
        $request->validate(['file' => 'required|mimes:pdf']);
        $folderPath = public_path('uploads/' . $id);
        if (!file_exists($folderPath))
            mkdir($folderPath, 0755, true);
        $file = $request->file;
        $filePath = $file->storeAs('uploads/' . $id);
        $file->move($filePath, "file.pdf");
        $session->status = 2;
        $session->touch();
        $session->save();
        $pdfFilePath = $filePath . "/file.pdf";
        $outputDirectory = '../public/uploads/' . $id . "/";
        ColorDetect::dispatch($id);
        return redirect("/print/$id");
    }
}