<?php

use App\Http\Controllers\DictionaryController;
use Illuminate\Support\Facades\Route;

// Dictionary API Routes
Route::get('/search', [DictionaryController::class, 'search']);
Route::get('/suggestions', [DictionaryController::class, 'suggestions']);
Route::post('/add-word', [DictionaryController::class, 'store'])->middleware('auth:sanctum');
