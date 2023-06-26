<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware("printing");
    }

    public function index()
    {
        return "test";
    }
}