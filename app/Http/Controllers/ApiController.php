<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware("apikey");
    }
    public function new(Request $request)
    {
        $check = true;
        while ($check) {
            $uuid = Str::uuid()->toString();
            if (Session::create(["session" => $uuid, "outlet_id" => $request->outlet, "status" => 0])) {
                $check = false;
                return response()->json(['success' => true, 'uuid' => $uuid], 200);
            }
        }
    }
    public function status(Request $request, $id)
    {
        $session = Session::where(["session" => $id, "outlet_id" => $request->outlet])->first();
        if ($session) {
            return response()->json(['success' => true, 'status' => $session->status], 200);
        }
        return response()->json(['success' => false, 'message' => "Not found"], 404);
    }
}