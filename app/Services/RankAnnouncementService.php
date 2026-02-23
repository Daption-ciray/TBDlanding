<?php

namespace App\Services;

use App\Models\LevelAnnouncement;
use App\Models\Team;
use App\Models\Viewer;
use Illuminate\Support\Facades\Cache;

class RankAnnouncementService
{
    private const CACHE_KEY_TEAM_RANKS = 'leaderboard:team:ranks';
    private const CACHE_KEY_VIEWER_RANKS = 'leaderboard:viewer:ranks';
    private const THROTTLE_MINUTES = 2;

    /**
     * Takım sıralaması değişimlerini kontrol et, duyuru oluştur.
     */
    public function syncTeamRankAnnouncements(): void
    {
        $throttleKey = 'rank_sync:teams:last';
        $last = Cache::get($throttleKey);
        if ($last && \Carbon\Carbon::parse($last)->diffInMinutes(now()) < self::THROTTLE_MINUTES) {
            return;
        }
        Cache::put($throttleKey, now()->toDateTimeString(), now()->addHour());

        $teams = Team::active()
            ->withCount('badges')
            ->orderByDesc('supporter_count')
            ->orderByDesc('badges_count')
            ->limit(20)
            ->get();

        $currentRanks = [];
        foreach ($teams as $i => $team) {
            $currentRanks[$team->id] = $i + 1;
        }

        $previous = Cache::get(self::CACHE_KEY_TEAM_RANKS, []);
        foreach ($teams as $i => $team) {
            $newRank = $i + 1;
            $oldRank = $previous[$team->id] ?? null;
            if ($oldRank !== null && $newRank < $oldRank) {
                $message = $newRank === 1
                    ? "{$team->name} 1. sıraya yükseldi! 🏆"
                    : "{$team->name} {$newRank}. sıraya yükseldi!";
                LevelAnnouncement::create([
                    'team_id' => $team->id,
                    'message' => $message,
                    'type' => 'system',
                    'meta' => [
                        'subtype' => 'team_rank_change',
                        'old_rank' => $oldRank,
                        'new_rank' => $newRank,
                    ],
                ]);
            }
        }
        Cache::put(self::CACHE_KEY_TEAM_RANKS, $currentRanks, now()->addDays(7));
    }

    /**
     * İzleyici sıralaması değişimlerini kontrol et, duyuru oluştur.
     */
    public function syncViewerRankAnnouncements(): void
    {
        $throttleKey = 'rank_sync:viewers:last';
        $last = Cache::get($throttleKey);
        if ($last && \Carbon\Carbon::parse($last)->diffInMinutes(now()) < self::THROTTLE_MINUTES) {
            return;
        }
        Cache::put($throttleKey, now()->toDateTimeString(), now()->addHour());

        $viewers = Viewer::orderByDesc('xp')
            ->limit(20)
            ->get();

        $currentRanks = [];
        foreach ($viewers as $i => $viewer) {
            $currentRanks[$viewer->id] = $i + 1;
        }

        $previous = Cache::get(self::CACHE_KEY_VIEWER_RANKS, []);
        foreach ($viewers as $i => $viewer) {
            $newRank = $i + 1;
            $oldRank = $previous[$viewer->id] ?? null;
            if ($oldRank !== null && $newRank < $oldRank) {
                $message = $newRank === 1
                    ? "{$viewer->name} izleyici sıralamasında 1. oldu! 👁️"
                    : "{$viewer->name} izleyici sıralamasında {$newRank}. sıraya yükseldi!";
                LevelAnnouncement::create([
                    'viewer_id' => $viewer->id,
                    'message' => $message,
                    'type' => 'system',
                    'meta' => [
                        'subtype' => 'viewer_rank_change',
                        'old_rank' => $oldRank,
                        'new_rank' => $newRank,
                    ],
                ]);
            }
        }
        Cache::put(self::CACHE_KEY_VIEWER_RANKS, $currentRanks, now()->addDays(7));
    }
}
