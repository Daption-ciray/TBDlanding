<?php

use App\Http\Controllers\Api\BadgeController;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\FeedController;
use App\Http\Controllers\Api\HealthController;
use App\Http\Controllers\Api\LeaderboardController;
use App\Http\Controllers\Api\MentorTesterController;
use App\Http\Controllers\Api\QuestController;
use App\Http\Controllers\Api\ViewerController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:60,1')->group(function () {

    // Public read-only endpoints
    Route::prefix('leaderboard')->group(function () {
        Route::get('/{type}', [LeaderboardController::class, 'index']);
    });

    Route::get('/badges', [BadgeController::class, 'index']);
    Route::get('/cards', [CardController::class, 'index']);
    Route::get('/quests', [QuestController::class, 'index']);
    Route::get('/feed', [FeedController::class, 'index']);

    // Team-authenticated endpoints
    Route::middleware(['team.auth', 'throttle:10,1'])->group(function () {
        Route::post('/badges/trade', [BadgeController::class, 'proposeTrade']);
        Route::patch('/badges/trade/{id}', [BadgeController::class, 'respondTrade']);

        Route::post('/cards/purchase', [CardController::class, 'purchase']);
        Route::post('/cards/{id}/use', [CardController::class, 'use']);

        Route::post('/quests/{id}/complete', [QuestController::class, 'complete']);

        Route::post('/mentor/request', [MentorTesterController::class, 'requestMentor']);
        Route::get('/mentor/status', [MentorTesterController::class, 'mentorStatus']);

        Route::post('/tester/request', [MentorTesterController::class, 'requestTester']);
        Route::get('/tester/status', [MentorTesterController::class, 'testerStatus']);
    });

    // Viewer endpoints
    Route::post('/viewer/register', [ViewerController::class, 'register'])
        ->middleware('throttle:10,1');

    Route::middleware(['viewer.auth'])->group(function () {
        Route::get('/viewer/{id}/stats', [ViewerController::class, 'stats']);
        Route::post('/viewer/heartbeat', [ViewerController::class, 'heartbeat'])
            ->middleware('throttle:2,1');
        Route::post('/viewer/claim', [ViewerController::class, 'claim'])
            ->middleware('throttle:5,1');
        Route::post('/social/share', [ViewerController::class, 'share'])
            ->middleware('throttle:10,1');
    });

    // Health check
    Route::get('/health', [HealthController::class, 'index']);
});
