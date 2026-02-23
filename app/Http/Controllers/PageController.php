<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\Card;
use App\Models\LevelAnnouncement;
use App\Models\Participant;
use App\Models\Quest;
use App\Models\Team;
use App\Models\Viewer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Giriş: CS tarzı taraf seçimi (ADEM vs BABA).
     */
    public function roleSelect(): View
    {
        return view('pages.role-select', [
            'roleSelect' => config('livingcode.role_select'),
            'event' => config('livingcode.event'),
        ]);
    }

    /**
     * Tanıtım sayfası — seçilen role göre (ADEM/BABA) vurgu.
     */
    public function welcome(Request $request): View
    {
        $role = $request->query('role') ?? session('livingcode_role', 'adem');
        if (! in_array($role, ['adem', 'baba'], true)) {
            $role = 'adem';
        }
        try {
            session(['livingcode_role' => $role]);
        } catch (\Throwable $e) {
            Log::warning('welcome: session write failed', ['error' => $e->getMessage(), 'role' => $role]);
        }

        return view('pages.welcome', [
            'role' => $role,
            'phases' => config('livingcode.phases'),
            'faqs' => config('livingcode.faqs'),
            'stats' => config('livingcode.stats'),
            'sponsorTiers' => config('livingcode.sponsor_tiers'),
            'event' => config('livingcode.event'),
            'contact' => config('livingcode.contact'),
            'countdownTarget' => config('livingcode.countdown_target'),
        ]);
    }

    public function arena(Request $request): View
    {
        $role = session('livingcode_role', 'adem');

        $leaderboardTeams = $this->getTeamLeaderboard();
        $leaderboardParticipants = $this->getParticipantLeaderboard();
        $leaderboardViewers = $this->getViewerLeaderboard();
        $feedItems = $this->getFeedItems();
        $cards = $this->getCards();
        $quests = $this->getQuests();
        $badges = $this->getBadges();

        try {
            $teamsForSelect = Team::active()->orderBy('name')->get(['id', 'name']);
        } catch (\Throwable) {
            $teamsForSelect = collect();
        }

        return view('pages.arena', [
            'role' => $role,
            'event' => config('livingcode.event'),
            'stats' => config('livingcode.stats'),
            'leaderboardTeams' => $leaderboardTeams,
            'leaderboardParticipants' => $leaderboardParticipants,
            'leaderboardViewers' => $leaderboardViewers,
            'feedItems' => $feedItems,
            'cards' => $cards,
            'quests' => $quests,
            'badges' => $badges,
            'teamsForSelect' => $teamsForSelect,
        ]);
    }

    public function viewer(Request $request): View
    {
        $topViewers = $this->getTopViewers();
        $leaderboardViewers = $this->getViewerLeaderboard();

        return view('pages.viewer', [
            'event' => config('livingcode.event'),
            'topViewers' => $topViewers,
            'leaderboardViewers' => $leaderboardViewers,
        ]);
    }

    private function getTeamLeaderboard(): array
    {
        try {
            return Cache::remember('page:leaderboard:teams', 120, function () {
                return Team::active()
                    ->withCount('badges')
                    ->orderByDesc('supporter_count')
                    ->orderByDesc('badges_count')
                    ->limit(10)
                    ->get()
                    ->map(fn (Team $t, int $i) => [
                        'rank' => $i + 1,
                        'name' => $t->name,
                        'role' => $t->role,
                        'badge_count' => $t->badges_count,
                        'supporter_count' => $t->supporter_count,
                    ])
                    ->toArray();
            });
        } catch (\Throwable $e) {
            Log::error('getTeamLeaderboard failed', ['error' => $e->getMessage()]);
            return [];
        }
    }

    private function getParticipantLeaderboard(): array
    {
        try {
            return Cache::remember('page:leaderboard:participants', 120, function () {
                return Participant::with('team:id,name,role')
                    ->limit(10)
                    ->get()
                    ->map(fn (Participant $p, int $i) => [
                        'rank' => $i + 1,
                        'name' => $p->name,
                        'team_name' => $p->team->name ?? '',
                        'role_in_team' => $p->role_in_team,
                    ])
                    ->toArray();
            });
        } catch (\Throwable $e) {
            Log::error('getParticipantLeaderboard failed', ['error' => $e->getMessage()]);
            return [];
        }
    }

    private function getViewerLeaderboard(): array
    {
        try {
            return Cache::remember('page:leaderboard:viewers', 120, function () {
                return Viewer::orderByDesc('xp')
                    ->limit(10)
                    ->get()
                    ->map(fn (Viewer $v, int $i) => [
                        'rank' => $i + 1,
                        'name' => $v->name,
                        'xp' => $v->xp,
                        'watch_minutes' => $v->total_watch_minutes,
                    ])
                    ->toArray();
            });
        } catch (\Throwable $e) {
            Log::error('getViewerLeaderboard failed', ['error' => $e->getMessage()]);
            return [];
        }
    }

    private function getFeedItems(): array
    {
        try {
            return Cache::remember('page:feed', 30, function () {
                return LevelAnnouncement::with(['team:id,name,role', 'viewer:id,name'])
                    ->orderByDesc('created_at')
                    ->limit(20)
                    ->get()
                    ->map(fn (LevelAnnouncement $a) => [
                        'message' => $a->message,
                        'type' => $a->type,
                        'icon' => $a->icon,
                        'meta' => $a->meta,
                        'team_name' => $a->team?->name,
                        'team_role' => $a->team?->role,
                        'viewer_name' => $a->viewer?->name,
                        'time_human' => $a->created_at->diffForHumans(),
                    ])
                    ->toArray();
            });
        } catch (\Throwable $e) {
            Log::error('getFeedItems failed', ['error' => $e->getMessage()]);
            return [];
        }
    }

    private function getCards(): array
    {
        try {
            return Cache::remember('page:cards', 300, function () {
                return Card::active()
                    ->orderBy('type')
                    ->orderBy('cost_credits')
                    ->get()
                    ->map(fn (Card $c) => [
                        'id' => $c->id,
                        'name' => $c->name,
                        'type' => $c->type,
                        'description' => $c->description,
                        'effect' => $c->effect_description,
                        'cost' => $c->cost_credits,
                        'rarity' => $c->rarity,
                        'stock' => $c->stock,
                        'available' => $c->isAvailable(),
                    ])
                    ->toArray();
            });
        } catch (\Throwable $e) {
            Log::error('getCards failed', ['error' => $e->getMessage()]);
            return [];
        }
    }

    private function getQuests()
    {
        try {
            return Cache::remember('page:quests', 60, function () {
                return Quest::active()
                    ->orderBy('expires_at')
                    ->get()
                    ->map(fn (Quest $q) => [
                        'id' => $q->id,
                        'title' => $q->title,
                        'description' => $q->description,
                        'type' => $q->type,
                        'xp_reward' => $q->xp_reward,
                        'credit_reward' => $q->credit_reward,
                        'icon' => $q->icon,
                        'difficulty' => $q->difficulty,
                        'expires_at' => $q->expires_at->toIso8601String(),
                        'remaining' => $q->remaining_time,
                        'max_completions' => $q->max_completions,
                        'current_completions' => $q->current_completions,
                        'expiring_soon' => $q->expires_at->diffInMinutes(now()) <= 60,
                    ]);
            });
        } catch (\Throwable $e) {
            Log::error('getQuests failed', ['error' => $e->getMessage()]);
            return collect();
        }
    }

    private function getBadges(): array
    {
        try {
            return Cache::remember('page:badges', 300, function () {
                return Badge::all()
                    ->map(fn (Badge $b) => [
                        'id' => $b->id,
                        'name' => $b->name,
                        'slug' => $b->slug,
                        'description' => $b->description,
                        'icon' => $b->icon,
                        'type' => $b->type,
                        'rarity' => $b->rarity,
                        'is_tradeable' => $b->is_tradeable,
                        'earned' => false,
                    ])
                    ->toArray();
            });
        } catch (\Throwable $e) {
            Log::error('getBadges failed', ['error' => $e->getMessage()]);
            return [];
        }
    }

    private function getTopViewers(): array
    {
        try {
            return Cache::remember('page:top_viewers', 120, function () {
                return Viewer::orderByDesc('total_watch_minutes')
                    ->limit(5)
                    ->get()
                    ->map(fn (Viewer $v) => [
                        'name' => $v->name,
                        'watch_minutes' => $v->total_watch_minutes,
                        'xp' => $v->xp,
                    ])
                    ->toArray();
            });
        } catch (\Throwable $e) {
            Log::error('getTopViewers failed', ['error' => $e->getMessage()]);
            return [];
        }
    }
}
