<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DictionaryController;
use App\Http\Controllers\WordController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dictionary Routes
Route::get('/', [DictionaryController::class, 'index'])->name('home');

// Word Management Routes (CRUD)
Route::middleware('auth')->group(function () {
    Route::get('/kelola-kata', [WordController::class, 'index'])->name('words.index');
    Route::get('/kelola-kata/create', [WordController::class, 'create'])->name('words.create');
    Route::post('/kelola-kata', [WordController::class, 'store'])->name('words.store');
    Route::get('/kelola-kata/{word}/edit', [WordController::class, 'edit'])->name('words.edit');
    Route::put('/kelola-kata/{word}', [WordController::class, 'update'])->name('words.update');
    Route::delete('/kelola-kata/{word}', [WordController::class, 'destroy'])->name('words.destroy');
});

// API Routes for dictionary
Route::get('/api/search', [DictionaryController::class, 'search']);
Route::get('/api/suggestions', [DictionaryController::class, 'suggestions']);
Route::post('/api/add-word', [DictionaryController::class, 'store'])->middleware('auth');
