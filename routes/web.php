<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AdminController::class, 'index']);
Route::get('/dashboard/{id}', [AdminController::class, 'dashboard']);
Route::get('/dashboard', [AdminController::class, 'dashboard']);
Route::post('/', [AdminController::class, 'login']);
Route::post('/dashboard/setting/change', [AdminController::class, 'setting']);

Route::post('/dashboard/outlet/new', [OutletController::class, 'store']);
Route::post('/dashboard/outlet/new', [OutletController::class, 'store']);


Route::get('/print/{id}', [UserController::class, 'index']);