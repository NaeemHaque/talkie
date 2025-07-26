<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeminiController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/gemini', [GeminiController::class, 'index'])->name('gemini');
Route::post('/gemini', [GeminiController::class, 'getResponse'])->name('gemini.response');
