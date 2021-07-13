<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Livewire\Product;
use App\Http\Livewire\Order;

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

Route::get('/', [LoginController::class, 'ShowLoginForm'])->name('login');
Route::get('/login', [LoginController::class, 'ShowLoginForm']);
Route::post('/login', [LoginController::class, 'login']);

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/products', Product::class);
    Route::get('/orders', Order::class);
});
