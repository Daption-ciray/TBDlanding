<?php

namespace App\Http\Controllers\Sura;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\CardPurchase;
use App\Models\Hucre;
use App\Models\LevelAnnouncement;
use App\Models\MentorRequest;
use App\Models\Participant;
use App\Models\Quest;
use App\Models\QuestCompletion;
use App\Models\SocialShare;
use App\Models\Team;
use App\Models\TesterRequest;
use App\Models\Viewer;
use App\Models\ViewerXpClaim;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SuraDashboardController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'hucreler' => Hucre::active()->count(),
            'teams' => Team::active()->count(),
            'participants' => Participant::count(),
            'viewers' => Viewer::count(),
            'active_quests' => Quest::active()->count(),
            'completed_quests' => QuestCompletion::count(),
            'card_purchases' => CardPurchase::count(),
            'mentor_requests' => MentorRequest::active()->count(),
            'tester_requests' => TesterRequest::active()->count(),
            'announcements' => LevelAnnouncement::count(),
            'social_shares' => SocialShare::count(),
            'pending_viewer_xp_claims' => ViewerXpClaim::pending()->count(),
        ];

        $recentAnnouncements = LevelAnnouncement::with(['team:id,name', 'viewer:id,name'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $topTeams = Team::active()
            ->withCount('badges')
            ->orderByDesc('supporter_count')
            ->orderByDesc('badges_count')
            ->limit(5)
            ->get();

        $pendingMentors = MentorRequest::with('team:id,name')
            ->pending()
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $pendingTesters = TesterRequest::with('team:id,name')
            ->pending()
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $badges = Badge::all();

        $systemHealth = $this->getSystemHealth();

        return view('sura.dashboard', [
            'stats' => $stats,
            'recentAnnouncements' => $recentAnnouncements,
            'topTeams' => $topTeams,
            'pendingMentors' => $pendingMentors,
            'pendingTesters' => $pendingTesters,
            'badges' => $badges,
            'systemHealth' => $systemHealth,
        ]);
    }

    private function getSystemHealth(): array
    {
        $checks = [];

        try {
            DB::connection()->getPdo();
            $checks['database'] = 'ok';
        } catch (\Throwable) {
            $checks['database'] = 'error';
        }

        try {
            Cache::store()->put('health_check', true, 10);
            $checks['cache'] = Cache::store()->get('health_check') ? 'ok' : 'error';
        } catch (\Throwable) {
            $checks['cache'] = 'error';
        }

        $checks['status'] = !in_array('error', $checks, true) ? 'healthy' : 'degraded';

        return $checks;
    }
}
