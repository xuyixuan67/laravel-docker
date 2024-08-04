<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return ('tammy');
});




Route::post('/api/orders', [OrderController::class, 'store']);

// Route::get('/api/orders', [OrderController::class, 'store']);
