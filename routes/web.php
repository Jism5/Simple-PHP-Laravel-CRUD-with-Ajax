<?php

use App\Http\Controllers\CrudController;
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
Route::get('/display_data', [CrudController::class, 'displayproduct']);
Route::get('/getdata/{id}', [CrudController::class, 'seteditdata']);
Route::post('/insertdata', [CrudController::class, 'insertproduct']);
Route::put('/update_data/{id}', [CrudController::class, 'updateproduct']);
Route::delete('/delete/{id}', [CrudController::class, 'deleteproduct']);

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
