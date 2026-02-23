<?php

namespace App\Http\Controllers\Sura;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\LevelAnnouncement;
use App\Models\Team;
use App\Models\Viewer;
use App\Models\ViewerXpClaim;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuraViewerController extends Controller
{
    public function index(): View
    {
        $viewers = Viewer::withCount('badges')
            ->orderByDesc('total_watch_minutes')
            ->paginate(20);
        $badges = Badge::orderBy('name')->get();

        return view('sura.viewers', ['viewers' => $viewers, 'badges' => $badges]);
    }

    public function giveXp(Request $request): JsonResponse
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

    public function assignBadge(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'badge_id' => 'required|exists:badges,id',
            'team_id' => 'nullable|exists:teams,id',
            'viewer_id' => 'nullable|exists:viewers,id',
        ]);

        $badge = Badge::findOrFail($validated['badge_id']);

        if ($validated['team_id'] ?? null) {
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
        } elseif ($validated['viewer_id'] ?? null) {
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

    public function claims(): View
    {
        $claims = ViewerXpClaim::with('viewer:id,name,email,xp')
            ->pending()
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('sura.viewer-claims', ['claims' => $claims]);
    }

    public function approveClaim(int $id): JsonResponse
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

    public function rejectClaim(Request $request, int $id): JsonResponse
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
}
