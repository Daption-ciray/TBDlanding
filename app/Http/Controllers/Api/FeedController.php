<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LevelAnnouncement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FeedController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'since' => 'nullable|date',
            'limit' => 'nullable|integer|min:1|max:50',
        ]);

        $since = $request->query('since');
        $limit = min((int) $request->query('limit', 20), 50);

        $cacheKey = 'api:feed:' . md5($since . $limit);
        $announcements = Cache::remember($cacheKey, 30, function () use ($since, $limit) {
            $query = LevelAnnouncement::with(['team:id,name,role', 'viewer:id,name'])
                ->orderByDesc('created_at');

            if ($since) {
                $query->where('created_at', '>', $since);
            }

            return $query->limit($limit)->get()->map(fn (LevelAnnouncement $a) => [
                'id' => $a->id,
                'message' => $a->message,
                'type' => $a->type,
                'icon' => $a->icon,
                'team_name' => $a->team?->name,
                'team_role' => $a->team?->role,
                'viewer_name' => $a->viewer?->name,
                'meta' => $a->meta,
                'time' => $a->created_at->toIso8601String(),
                'time_human' => $a->created_at->diffForHumans(),
            ]);
        });

        return response()->json(['success' => true, 'data' => $announcements]);
    }
}
