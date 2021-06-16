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

//Route::get('/', function () {
//    return view('home');
//});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\FileProcessController::class, 'fileConvertForm']);
    Route::post('file-upload',  [App\Http\Controllers\FileProcessController::class, 'processFile'])->name('file.upload.post');
    Route::get('file-download/{id}',  [App\Http\Controllers\FileProcessController::class, 'downloadFile'])->name('file.download.output');
    Route::get('job-history',  [App\Http\Controllers\FileProcessController::class, 'jobHistoryView'])->name('file.job-history');
});



