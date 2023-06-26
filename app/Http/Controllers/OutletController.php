<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OutletController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function store(Request $request)
    {
        $request->validate(["outlet" => "required"]);
        $uuid = Str::uuid()->toString();
        if (Outlet::create(["name" => $request->outlet, "key" => $uuid])) {
            return redirect()->back()->with('message', "Success add new outlet, API KEY: $uuid");
        }
        return redirect()->back()->with('message', "Error");


    }
}