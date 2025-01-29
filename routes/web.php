<?php

use App\Http\Controllers\ContentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/create', [ContentController::class, 'create'])->name('contents.index');
Route::post('/contents', [ContentController::class, 'store'])->name('contents.store');
