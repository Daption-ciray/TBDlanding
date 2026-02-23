<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\Card;
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
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class SuraController extends Controller
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

        return view('sura.dashboard', [
            'stats' => $stats,
            'recentAnnouncements' => $recentAnnouncements,
            'topTeams' => $topTeams,
            'pendingMentors' => $pendingMentors,
            'pendingTesters' => $pendingTesters,
            'badges' => $badges,
        ]);
    }

    public function hucreler(): View
    {
        $hucreler = Hucre::active()
            ->with(['teams' => function ($query) {
                $query->withCount(['badges', 'participants'])->orderByDesc('supporter_count');
            }])
            ->orderBy('role')
            ->orderBy('name')
            ->get();

        return view('sura.hucreler', ['hucreler' => $hucreler]);
    }

    public function createHucre(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'role' => 'required|in:adem,baba',
            'credits' => 'nullable|integer|min:0',
            'xp' => 'nullable|integer|min:0',
        ]);

        $hucre = Hucre::create([
            'name' => $validated['name'],
            'role' => $validated['role'],
            'credits' => $validated['credits'] ?? 100,
            'xp' => $validated['xp'] ?? 0,
        ]);

        LevelAnnouncement::create([
            'message' => "Yeni hücre oluşturuldu: {$hucre->name}",
            'type' => 'system',
            'meta' => ['hucre_id' => $hucre->id],
        ]);

        return response()->json(['success' => true, 'hucre' => [
            'id' => $hucre->id,
            'name' => $hucre->name,
            'role' => $hucre->role,
        ]], 201);
    }

    public function updateHucre(Request $request, int $id): JsonResponse
    {
        $hucre = Hucre::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'role' => 'required|in:adem,baba',
            'credits' => 'nullable|integer|min:0',
            'xp' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $hucre->update($validated);

        LevelAnnouncement::create([
            'message' => "{$hucre->name} hücresi güncellendi.",
            'type' => 'system',
            'meta' => ['hucre_id' => $hucre->id],
        ]);

        return response()->json(['success' => true]);
    }

    public function deleteHucre(int $id): JsonResponse
    {
        $hucre = Hucre::findOrFail($id);
        $hucreName = $hucre->name;
        
        // Hücredeki takımların hucre_id'sini null yap
        $hucre->teams()->update(['hucre_id' => null]);
        
        $hucre->delete();

        LevelAnnouncement::create([
            'message' => "{$hucreName} hücresi silindi.",
            'type' => 'system',
        ]);

        return response()->json(['success' => true]);
    }

    public function teams(Request $request): View
    {
        $query = Team::withCount(['badges', 'participants', 'cardPurchases', 'questCompletions'])
            ->orderByDesc('supporter_count');

        if ($request->filled('role') && in_array($request->role, ['adem', 'baba'], true)) {
            $query->where('role', $request->role);
        }

        $teams = $query->with('hucre:id,name,role')->paginate(20)->withQueryString();
        $hucreler = Hucre::active()->orderBy('name')->get(['id', 'name', 'role']);
        $badges = Badge::orderBy('name')->get(['id', 'name']);

        return view('sura.teams', ['teams' => $teams, 'hucreler' => $hucreler, 'badges' => $badges]);
    }

    public function createTeam(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:teams,name',
            'role' => 'required|in:adem,baba',
            'hucre_id' => 'nullable|exists:hucreler,id',
            'supporter_count' => 'nullable|integer|min:0',
        ]);

        $team = Team::create([
            'name' => $validated['name'],
            'role' => $validated['role'],
            'hucre_id' => $validated['hucre_id'] ?? null,
            'supporter_count' => $validated['supporter_count'] ?? 0,
        ]);

        LevelAnnouncement::create([
            'message' => "Yeni takım oluşturuldu: {$team->name}",
            'type' => 'system',
            'meta' => ['team_id' => $team->id],
        ]);

        return response()->json(['success' => true, 'team' => [
            'id' => $team->id,
            'name' => $team->name,
            'role' => $team->role,
        ]], 201);
    }

    public function updateTeam(Request $request, int $id): JsonResponse
    {
        $team = Team::findOrFail($id);
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('teams', 'name')->ignore($id)],
            'role' => 'required|in:adem,baba',
            'hucre_id' => 'nullable|exists:hucreler,id',
            'supporter_count' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $team->update($validated);

        LevelAnnouncement::create([
            'team_id' => $team->id,
            'message' => "{$team->name} takımı güncellendi.",
            'type' => 'system',
        ]);

        return response()->json(['success' => true]);
    }

    public function deleteTeam(int $id): JsonResponse
    {
        $team = Team::findOrFail($id);
        $teamName = $team->name;
        $team->delete();

        LevelAnnouncement::create([
            'message' => "{$teamName} takımı silindi.",
            'type' => 'system',
        ]);

        return response()->json(['success' => true]);
    }

    public function viewers(): View
    {
        $viewers = Viewer::withCount('badges')
            ->orderByDesc('total_watch_minutes')
            ->paginate(20);
        $badges = Badge::orderBy('name')->get();

        return view('sura.viewers', ['viewers' => $viewers, 'badges' => $badges]);
    }

    public function quests(): View
    {
        $quests = Quest::withCount('completions')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('sura.quests', ['quests' => $quests]);
    }

    public function announcements(): View
    {
        $announcements = LevelAnnouncement::with(['team:id,name', 'viewer:id,name'])
            ->orderByDesc('created_at')
            ->paginate(30);

        return view('sura.announcements', ['announcements' => $announcements]);
    }

    /**
     * İzleyici duyuruları: viewer_id dolu olanlar, düzenlenebilir.
     */
    public function viewerAnnouncements(): View
    {
        $announcements = LevelAnnouncement::with(['viewer:id,name,email'])
            ->whereNotNull('viewer_id')
            ->orderByDesc('created_at')
            ->paginate(30);

        return view('sura.viewer-announcements', ['announcements' => $announcements]);
    }

    public function createAnnouncement(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:500',
            'type' => 'required|in:level_up,badge_earned,quest_complete,card_used,tester_called,trade_complete,social_share,system',
            'team_id' => 'nullable|exists:teams,id',
            'viewer_id' => 'nullable|exists:viewers,id',
        ]);

        $announcement = LevelAnnouncement::create($validated);

        return response()->json([
            'success' => true,
            'announcement' => [
                'id' => $announcement->id,
                'message' => $announcement->message,
                'type' => $announcement->type,
                'created_at' => $announcement->created_at->diffForHumans(),
            ],
        ]);
    }

    public function updateAnnouncement(Request $request, int $id): JsonResponse
    {
        $announcement = LevelAnnouncement::findOrFail($id);
        $validated = $request->validate([
            'message' => 'required|string|max:500',
            'type' => 'required|in:level_up,badge_earned,quest_complete,card_used,tester_called,trade_complete,social_share,system',
            'team_id' => 'nullable|exists:teams,id',
            'viewer_id' => 'nullable|exists:viewers,id',
        ]);
        $announcement->update($validated);
        return response()->json(['success' => true]);
    }

    public function deleteAnnouncement(int $id): JsonResponse
    {
        LevelAnnouncement::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function assignBadge(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'badge_id' => 'required|exists:badges,id',
            'team_id' => 'nullable|exists:teams,id',
            'viewer_id' => 'nullable|exists:viewers,id',
        ]);

        $badge = Badge::findOrFail($validated['badge_id']);

        if ($validated['team_id']) {
            $team = Team::findOrFail($validated['team_id']);
            if (!$team->badges()->where('badge_id', $badge->id)->exists()) {
                $team->badges()->attach($badge->id, ['earned_at' => now()]);

                LevelAnnouncement::create([
                    'team_id' => $team->id,
                    'message' => "{$team->name}, \"{$badge->name}\" rozetini kazandı!",
                    'type' => 'badge_earned',
                    'meta' => ['badge' => $badge->name],
                ]);
            }
        } elseif ($validated['viewer_id']) {
            $viewer = Viewer::findOrFail($validated['viewer_id']);
            if (!$viewer->badges()->where('badge_id', $badge->id)->exists()) {
                $viewer->badges()->attach($badge->id, ['earned_at' => now()]);

                LevelAnnouncement::create([
                    'viewer_id' => $viewer->id,
                    'message' => "{$viewer->name}, \"{$badge->name}\" rozetini kazandı!",
                    'type' => 'badge_earned',
                    'meta' => ['badge' => $badge->name],
                ]);
            }
        }

        return response()->json(['success' => true]);
    }

    public function giveCredits(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'hucre_id' => 'required|exists:hucreler,id',
            'amount' => 'required|integer|min:1|max:1000',
        ]);

        $hucre = Hucre::findOrFail($validated['hucre_id']);
        $hucre->increment('credits', $validated['amount']);

        $teamNames = $hucre->teams->pluck('name')->join(', ');
        LevelAnnouncement::create([
            'message' => "Şura, {$hucre->name} ({$teamNames}) hücresine {$validated['amount']} kredi verdi!",
            'type' => 'system',
            'meta' => ['credits' => $validated['amount'], 'hucre_id' => $hucre->id],
        ]);

        return response()->json(['success' => true, 'new_credits' => $hucre->fresh()->credits]);
    }

    public function giveViewerXp(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'viewer_id' => 'required|exists:viewers,id',
            'amount' => 'required|integer|min:1|max:500',
        ]);

        $viewer = Viewer::findOrFail($validated['viewer_id']);
        $viewer->addXp($validated['amount']);

        LevelAnnouncement::create([
            'viewer_id' => $viewer->id,
            'message' => "Şura, {$viewer->name}'a {$validated['amount']} XP verdi!",
            'type' => 'system',
            'meta' => ['xp' => $validated['amount']],
        ]);

        return response()->json(['success' => true, 'new_xp' => $viewer->fresh()->xp]);
    }

    public function viewerClaims(): View
    {
        $claims = ViewerXpClaim::with('viewer:id,name,email,xp')
            ->pending()
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('sura.viewer-claims', ['claims' => $claims]);
    }

    public function approveViewerClaim(int $id): JsonResponse
    {
        $claim = ViewerXpClaim::with('viewer')->pending()->findOrFail($id);
        $claim->update([
            'status' => 'approved',
            'reviewed_at' => now(),
        ]);

        $viewer = $claim->viewer;
        $viewer->addXp($claim->points_requested);

        LevelAnnouncement::create([
            'viewer_id' => $viewer->id,
            'message' => "{$viewer->name} sosyal paylaşım kanıtı onaylandı! +{$claim->points_requested} XP",
            'type' => 'social_share',
            'meta' => ['platform' => $claim->platform, 'points' => $claim->points_requested],
        ]);

        return response()->json(['success' => true, 'new_xp' => $viewer->fresh()->xp]);
    }

    public function rejectViewerClaim(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);
        $claim = ViewerXpClaim::pending()->findOrFail($id);
        $claim->update([
            'status' => 'rejected',
            'reviewed_at' => now(),
            'rejection_reason' => $validated['reason'] ?? null,
        ]);
        return response()->json(['success' => true]);
    }

    public function resolveMentor(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'mentor_name' => 'nullable|string|max:100',
            'status' => 'required|in:assigned,in_progress,resolved',
        ]);

        $mentorRequest = MentorRequest::with('team')->findOrFail($id);
        $mentorRequest->update(array_merge($validated, [
            'resolved_at' => $validated['status'] === 'resolved' ? now() : null,
        ]));

        if ($validated['status'] === 'resolved') {
            LevelAnnouncement::create([
                'team_id' => $mentorRequest->team_id,
                'message' => "{$mentorRequest->team->name}'ın mentor talebi çözüldü: {$mentorRequest->topic}",
                'type' => 'system',
                'meta' => ['mentor' => $validated['mentor_name'] ?? 'Şura'],
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function resolveTester(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'feedback' => 'nullable|string|max:1000',
            'rating' => 'nullable|integer|min:1|max:5',
            'status' => 'required|in:testing,completed',
        ]);

        $testerRequest = TesterRequest::with('team')->findOrFail($id);
        $testerRequest->update(array_merge($validated, [
            'tested_at' => $validated['status'] === 'completed' ? now() : null,
        ]));

        if ($validated['status'] === 'completed') {
            LevelAnnouncement::create([
                'team_id' => $testerRequest->team_id,
                'message' => "{$testerRequest->team->name}'ın oyunu test edildi!",
                'type' => 'tester_called',
                'meta' => ['rating' => $validated['rating'] ?? null],
            ]);
        }

        return response()->json(['success' => true]);
    }
}
