<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/book', App\Http\Controllers\BookController::class);
Route::resource('/orders', App\Http\Controllers\OrderController::class);
// success and cancel url route ...
Route::get('/payment/{status}', [App\Http\Controllers\OrderController::class, 'ThawaniCallBack']);
