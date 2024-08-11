<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/initialize', [ApiController::class, 'initialize'])->withoutMiddleware('throttle');
Route::get('/{id}/status', [ApiController::class, 'status'])->withoutMiddleware('throttle');
Route::post('/{id}/update', [ApiController::class, 'updateStatus'])->withoutMiddleware('throttle');
