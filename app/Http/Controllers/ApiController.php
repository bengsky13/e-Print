<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;
use App\Models\Session;
use App\Models\Transaction;
use Illuminate\Support\Str;

class ApiController extends Controller
{
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
                return response()->json(['success' => true, 'uuid' => $uuid], 200);
            }
        }
    }
    public function updateStatus(Request $request)
    {
        $outletId = $request->attributes->get('outlet');

        $session = Session::where(["session" => $id, "outlet_id" => $outletId])->first();
        if ($session) {
            $data = ['success' => true, 'status' => $session->status];
            if ($session->status == 3) {
                $session->status = 4;
                $session->touch();
                $session->save();
            }
            return response()->json($session, 200);
        }
        return response()->json(['success' => false, 'message' => "Not found"], 404);
    }
    public function status(Request $request, $id)
    {
        $outletId = $request->attributes->get('outlet');

        $session = Session::where(["session" => $id, "outlet_id" => $outletId])->first();
        if ($session) {
            $data = ['success' => true, 'status' => $session->status];
            if ($session->status == 3) {
                $trx = Transaction::where(["session_id" => $session->id])->first();
                $data['qr'] = $trx->qr;
                $data['amount'] = "Rp" . number_format($trx->amount);
            }
            return response()->json($data, 200);
        }
        return response()->json(['success' => false, 'message' => "Not found"], 404);
    }
}