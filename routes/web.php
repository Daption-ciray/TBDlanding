<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'roleSelect'])->name('role-select');
Route::get('/welcome', [PageController::class, 'welcome'])->name('welcome');

// Google Form Bildirim Ucu
Route::post('/api/google-form-sync', [PageController::class, 'registerFromGoogleForm']);

