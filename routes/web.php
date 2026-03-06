<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'roleSelect'])->name('role-select');
Route::get('/welcome', [PageController::class, 'welcome'])->name('welcome');
Route::post('/toggle-theme', [PageController::class, 'toggleTheme'])->name('toggle-theme');

