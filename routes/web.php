<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\SuraAuthController;
use App\Http\Controllers\Sura\SuraDashboardController;
use App\Http\Controllers\Sura\SuraTeamController;
use App\Http\Controllers\Sura\SuraHucreController;
use App\Http\Controllers\Sura\SuraAnnouncementController;
use App\Http\Controllers\Sura\SuraViewerController;
use App\Http\Controllers\Sura\SuraSupportController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'roleSelect'])->name('role-select');
Route::get('/evren', [PageController::class, 'welcome'])->name('welcome');
// Route::get('/arena', [PageController::class, 'arena'])->name('arena');
// Route::get('/izleyici', [PageController::class, 'viewer'])->name('viewer');

// Route::redirect('/evren/oyun', '/arena')->name('game');
Route::redirect('/arena', '/');
Route::redirect('/izleyici', '/');
Route::redirect('/evren/oyun', '/');

// Sura Panel Routes
Route::prefix('sura')->name('sura.')->group(function () {
    Route::get('/login', [SuraAuthController::class, 'login'])->name('login');
    Route::post('/login', [SuraAuthController::class, 'login']);
    Route::get('/logout', [SuraAuthController::class, 'logout'])->name('logout');

    Route::middleware('sura.auth')->group(function () {
        // Dashboard
        Route::get('/dashboard', [SuraDashboardController::class, 'dashboard'])->name('dashboard');

        // Hucre management
        Route::get('/hucreler', [SuraHucreController::class, 'index'])->name('hucreler');
        Route::post('/hucre', [SuraHucreController::class, 'store'])->name('hucre.create');
        Route::put('/hucre/{id}', [SuraHucreController::class, 'update'])->name('hucre.update');
        Route::delete('/hucre/{id}', [SuraHucreController::class, 'destroy'])->name('hucre.delete');
        Route::post('/credits/give', [SuraHucreController::class, 'giveCredits'])->name('credits.give');

        // Team management
        Route::get('/takimlar', [SuraTeamController::class, 'index'])->name('teams');
        Route::post('/team', [SuraTeamController::class, 'store'])->name('team.create');
        Route::put('/team/{id}', [SuraTeamController::class, 'update'])->name('team.update');
        Route::delete('/team/{id}', [SuraTeamController::class, 'destroy'])->name('team.delete');

        // Viewer management
        Route::get('/viewers', [SuraViewerController::class, 'index'])->name('viewers');
        Route::post('/viewer/xp', [SuraViewerController::class, 'giveXp'])->name('viewer.xp');
        Route::post('/badge/assign', [SuraViewerController::class, 'assignBadge'])->name('badge.assign');
        Route::get('/viewer-claims', [SuraViewerController::class, 'claims'])->name('viewer-claims');
        Route::post('/viewer-claim/{id}/approve', [SuraViewerController::class, 'approveClaim'])->name('viewer-claim.approve');
        Route::post('/viewer-claim/{id}/reject', [SuraViewerController::class, 'rejectClaim'])->name('viewer-claim.reject');

        // Announcements
        Route::get('/announcements', [SuraAnnouncementController::class, 'index'])->name('announcements');
        Route::get('/viewer-announcements', [SuraAnnouncementController::class, 'viewerAnnouncements'])->name('viewer-announcements');
        Route::post('/announcement', [SuraAnnouncementController::class, 'store'])->name('announcement.create');
        Route::put('/announcement/{id}', [SuraAnnouncementController::class, 'update'])->name('announcement.update');
        Route::delete('/announcement/{id}', [SuraAnnouncementController::class, 'destroy'])->name('announcement.delete');

        // Quests & Support
        Route::get('/quests', [SuraSupportController::class, 'quests'])->name('quests');
        Route::post('/quest', [SuraSupportController::class, 'storeQuest'])->name('quest.create');
        Route::put('/quest/{id}', [SuraSupportController::class, 'updateQuest'])->name('quest.update');
        Route::delete('/quest/{id}', [SuraSupportController::class, 'destroyQuest'])->name('quest.delete');
        Route::post('/mentor/{id}/resolve', [SuraSupportController::class, 'resolveMentor'])->name('mentor.resolve');
        Route::post('/tester/{id}/resolve', [SuraSupportController::class, 'resolveTester'])->name('tester.resolve');

        // Badge & Card CRUD
        Route::post('/badge/create', [SuraSupportController::class, 'storeBadge'])->name('badge.create');
        Route::post('/card', [SuraSupportController::class, 'storeCard'])->name('card.create');
        Route::put('/card/{id}', [SuraSupportController::class, 'updateCard'])->name('card.update');
    });
});
