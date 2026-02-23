<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\BadgeTrade;
use App\Models\LevelAnnouncement;
use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $teamId = $request->query('team_id');
        $viewerId = $request->query('viewer_id');

        $badges = Badge::all()->map(function (Badge $badge) use ($teamId, $viewerId) {
            $earned = false;
            if ($teamId) {
                $earned = $badge->teams()->where('team_id', $teamId)->exists();
            } elseif ($viewerId) {
                $earned = $badge->viewers()->where('viewer_id', $viewerId)->exists();
            }

            return [
                'id' => $badge->id,
                'name' => $badge->name,
                'slug' => $badge->slug,
                'description' => $badge->description,
                'icon' => $badge->icon,
                'type' => $badge->type,
                'rarity' => $badge->rarity,
                'rarity_color' => $badge->rarity_color,
                'is_tradeable' => $badge->is_tradeable,
                'earned' => $earned,
            ];
        });

        return response()->json(['success' => true, 'data' => $badges]);
    }

    public function proposeTrade(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'from_team_id' => 'required|exists:teams,id',
            'to_team_id' => 'required|exists:teams,id|different:from_team_id',
            'badge_id' => 'required|exists:badges,id',
            'offered_badge_id' => 'nullable|exists:badges,id',
        ]);

        $badge = Badge::findOrFail($validated['badge_id']);
        if (!$badge->is_tradeable) {
            return response()->json(['success' => false, 'error' => 'Bu rozet takas edilemez.'], 422);
        }

        $fromTeam = Team::findOrFail($validated['from_team_id']);
        if (!$fromTeam->badges()->where('badge_id', $badge->id)->exists()) {
            return response()->json(['success' => false, 'error' => 'Bu rozete sahip değilsiniz.'], 422);
        }

        $trade = BadgeTrade::create($validated);

        return response()->json(['success' => true, 'data' => ['trade_id' => $trade->id]]);
    }

    public function respondTrade(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'action' => 'required|in:accepted,rejected',
        ]);

        $trade = BadgeTrade::with(['fromTeam', 'toTeam', 'badge', 'offeredBadge'])->findOrFail($id);

        if (!$trade->isPending()) {
            return response()->json(['success' => false, 'error' => 'Bu takas artık aktif değil.'], 422);
        }

        $trade->update(['status' => $validated['action']]);

        if ($validated['action'] === 'accepted') {
            $trade->fromTeam->badges()->detach($trade->badge_id);
            $trade->toTeam->badges()->attach($trade->badge_id, ['earned_at' => now()]);

            if ($trade->offered_badge_id) {
                $trade->toTeam->badges()->detach($trade->offered_badge_id);
                $trade->fromTeam->badges()->attach($trade->offered_badge_id, ['earned_at' => now()]);
            }

            LevelAnnouncement::create([
                'team_id' => $trade->from_team_id,
                'message' => "{$trade->fromTeam->name} ve {$trade->toTeam->name} rozet takası yaptı!",
                'type' => 'trade_complete',
                'meta' => ['badge' => $trade->badge->name, 'from' => $trade->fromTeam->name, 'to' => $trade->toTeam->name],
            ]);
        }

        return response()->json(['success' => true, 'data' => ['status' => $trade->status]]);
    }
}
