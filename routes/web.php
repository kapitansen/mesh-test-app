<?php

use App\Http\Controllers\MeshUploader;
use App\Http\Controllers\RowController;
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
    return view('welcome', ['upload' => 'none']);
});

Route::post('/', [MeshUploader::class, 'upload']);

Route::get('/index', [RowController::class, 'index']);
