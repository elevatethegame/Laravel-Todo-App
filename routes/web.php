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
    return view('index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/home', [App\Http\Controllers\HomeController::class, 'store']);
Route::delete('/home/list/{list_id}', [App\Http\Controllers\HomeController::class, 'destroy']);

Route::get('/list/{list_id}/items', [App\Http\Controllers\ItemsController::class, 'index']);
Route::post('/list/{list_id}/items', [App\Http\Controllers\ItemsController::class, 'store']);
Route::put('/list/{list_id}/items/{item_id}', [App\Http\Controllers\ItemsController::class, 'markCompleted']);
