<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Participant;
use App\Models\Viewer;
use App\Services\RankAnnouncementService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class LeaderboardController extends Controller
{
    public function __construct(
        private RankAnnouncementService $rankAnnouncementService
    ) {}

    public function index(string $type): JsonResponse
    {
        return match ($type) {
            'teams' => $this->teams(),
            'participants' => $this->participants(),
            'viewers' => $this->viewers(),
            default => response()->json(['success' => false, 'error' => 'Geçersiz tür.'], 400),
        };
    }

    private function teams(): JsonResponse
    {
        $this->rankAnnouncementService->syncTeamRankAnnouncements();

        $teams = Cache::remember('api:leaderboard:teams', 120, function () {
            return Team::active()
                ->withCount('badges')
                ->orderByDesc('supporter_count')
                ->orderByDesc('badges_count')
                ->limit(20)
                ->get()
                ->map(fn (Team $t, int $i) => [
                    'rank' => $i + 1,
                    'id' => $t->id,
                    'name' => $t->name,
                    'role' => $t->role,
                    'credits' => $t->credits,
                    'badge_count' => $t->badges_count,
                    'supporter_count' => $t->supporter_count,
                    'logo' => $t->logo,
                ]);
        });

        return response()->json(['success' => true, 'data' => $teams]);
    }

    private function participants(): JsonResponse
    {
        $participants = Cache::remember('api:leaderboard:participants', 120, function () {
            return Participant::with('team:id,name,role')
                ->limit(20)
                ->get()
                ->map(fn (Participant $p, int $i) => [
                    'rank' => $i + 1,
                    'id' => $p->id,
                    'name' => $p->name,
                    'role_in_team' => $p->role_in_team,
                    'team_name' => $p->team->name ?? '',
                    'team_role' => $p->team->role ?? '',
                ]);
        });

        return response()->json(['success' => true, 'data' => $participants]);
    }

    private function viewers(): JsonResponse
    {
        $this->rankAnnouncementService->syncViewerRankAnnouncements();

        $viewers = Cache::remember('api:leaderboard:viewers', 120, function () {
            return Viewer::withCount('badges')
                ->orderByDesc('xp')
                ->limit(20)
                ->get()
                ->map(fn (Viewer $v, int $i) => [
                    'rank' => $i + 1,
                    'id' => $v->id,
                    'name' => $v->name,
                    'xp' => $v->xp,
                    'watch_minutes' => $v->total_watch_minutes,
                    'badge_count' => $v->badges_count,
                    'streak' => $v->current_streak,
                ]);
        });

        return response()->json(['success' => true, 'data' => $viewers]);
    }
}
