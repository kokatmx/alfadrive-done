<?php

use App\Http\Controllers\FilesController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [FilesController::class,'index'])->name('files');


// Route::get('/files', [FilesController::class,'index'])->name('files');
Route::get('/download/{filesId}', [FilesController::class, 'downloadFile'])->name('download');