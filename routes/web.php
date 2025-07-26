<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeminiController;

Route::get('/chat', [GeminiController::class, 'getResponse'])->name('gemini.chat');
Route::post('/chat', [GeminiController::class, 'getResponse'])->name('gemini.send');

Route::post('/chat/clear', [GeminiController::class, 'clearConversation'])->name('gemini.clear');
Route::post('/chat/new', [GeminiController::class, 'newConversation'])->name('gemini.new');

// If you want to keep your old route as well:
Route::match(['GET', 'POST'], '/', [GeminiController::class, 'getResponse']);
