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
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/transaction', [App\Http\Controllers\TransactionController::class, 'index'])->name('transaction');
Route::get('/transaction/add', [App\Http\Controllers\TransactionController::class, 'create'])->name('transaction.add');
Route::post('/transaction/insert', [App\Http\Controllers\TransactionController::class, 'store'])->name('transaction.insert');
