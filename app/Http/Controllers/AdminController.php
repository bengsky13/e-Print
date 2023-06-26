<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::user())
            return redirect("/dashboard");
        return view("login");
    }
    public function dashboard()
    {
        if (!Auth::user())
            return redirect("/");
        return view("dashboard");
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (
            Auth::attempt([
                "email" => $request->email,
                "password" => $request->password
            ])
        )
            return redirect('/dashboard');
        return redirect('/')->withErrors('Wrong Email or Password');
    }

    public function setting(Request $request)
    {
        $request->validate(["bnw" => "required|numeric|min:0", "colored" => "required|numeric|min:0"]);
        $setting = Setting::first();
        $setting->bnw = $request->bnw;
        $setting->colored = $request->colored;
        $setting->touch();
        $setting->save();
        return redirect()->back()->with("message", "Success");
    }
}