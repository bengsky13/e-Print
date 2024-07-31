<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;
use App\Models\Session;
use App\Models\Transaction;
use App\Http\Controllers\Midtrans;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function deleteDirectory($dirPath) {
        if (!is_dir($dirPath)) {
            return false;
        }
    
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dirPath, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );
    
        foreach ($files as $fileinfo) {
            $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
            $todo($fileinfo->getRealPath());
        }
    
        return rmdir($dirPath);
    }
    public function __construct()
    {
        $this->middleware("apikey");
    }
    public function initialize(Request $request)
    {
        $check = true;
        while ($check) {
            $uuid = Str::uuid()->toString();
            $outletId = $request->attributes->get('outlet');
            if (Session::create(["session" => $uuid, "outlet_id" => $outletId, "status" => 0])) {
                $check = false;
                $sessions = Session::where('session', '!=', $uuid)->where('outlet_id', '=', $outletId)->get();
                foreach($sessions as $session){
                    shell_exec("rm -rf uploads/".$session['session']);
                }
                return response()->json(['success' => true, 'uuid' => $uuid], 200);
            }
        }
    }
    public function updateStatus(Request $request, $id)
    {
        $outletId = $request->attributes->get('outlet');

        $session = Session::where(["session" => $id, "outlet_id" => $outletId])->first();
        if ($session) {
            $data = ['success' => true, 'status' => $session->status];
            $session->status = $request->status;
            $session->touch();
            $session->save();
            return response()->json($session, 200);
        }
        return response()->json(['success' => false, 'message' => "Not found"], 404);
    }
    public function status(Request $request, $id)
    {
        $outletId = $request->attributes->get('outlet');

        $session = Session::where(["session" => $id, "outlet_id" => $outletId])->first();
        if ($session) {
            $data = ['success' => true, 'status' => $session->status, 'color' => $session->color];
            if ($session->status == 3) {
                $trx = Transaction::where(["session_id" => $session->id])->first();
                $paymentStatus = new Midtrans;
                $check = $paymentStatus->checkTransaction($trx->trx_uuid);
                if($check->transaction_status == "settlement"){
                    $trx->status = 200;
                    $session->status = 4;
                    $trx->touch();
                    $trx->save();
                    $session->touch();
                    $session->save();
                }
                $data['qr'] = $trx->qr;
                $data['amount'] = "Rp" . number_format($trx->amount);
            }
            return response()->json($data, 200);
        }
        return response()->json(['success' => false, 'message' => "Not found"], 404);
    }
}