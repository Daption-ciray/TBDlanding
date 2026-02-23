<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LevelAnnouncement;
use App\Models\SocialShare;
use App\Models\Viewer;
use App\Models\ViewerXpClaim;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ViewerController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        // Ensure JSON body is merged (Laravel usually does this when Content-Type is application/json; fallback if input is empty)
        $content = $request->getContent();
        if ($content && ! $request->hasAny(['name', 'email'])) {
            $decoded = json_decode($content, true);
            if (is_array($decoded)) {
                $request->merge($decoded);
            }
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
        ]);

        $viewer = Viewer::firstOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['name'],
                'session_token' => Viewer::generateToken(),
            ]
        );

        if ($viewer->wasRecentlyCreated === false) {
            $viewer->update(['name' => $validated['name']]);
        }

        return response()->json([
            'success' => true,
            'viewer' => $this->viewerResponse($viewer),
        ]);
    }

    /**
     * Kayıtlı izleyici e-posta ile giriş yapar.
     */
    public function login(Request $request): JsonResponse
    {
        $content = $request->getContent();
        if ($content && ! $request->has('email')) {
            $decoded = json_decode($content, true);
            if (is_array($decoded)) {
                $request->merge($decoded);
            }
        }

        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $viewer = Viewer::where('email', $validated['email'])->first();

        if (! $viewer) {
            return response()->json([
                'error' => 'Bu e-posta ile kayıtlı izleyici bulunamadı. Önce kayıt olun.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'viewer' => $this->viewerResponse($viewer),
        ]);
    }

    private function viewerResponse(Viewer $viewer): array
    {
        return [
            'id' => $viewer->id,
            'name' => $viewer->name,
            'xp' => $viewer->xp,
            'watch_minutes' => $viewer->total_watch_minutes,
            'streak' => $viewer->current_streak,
            'token' => $viewer->session_token,
        ];
    }

    public function stats(int $id): JsonResponse
    {
        $viewer = Viewer::withCount('badges')->findOrFail($id);

        $badges = $viewer->badges()->get()->map(fn ($b) => [
            'name' => $b->name,
            'icon' => $b->icon,
            'rarity' => $b->rarity,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $viewer->id,
                'name' => $viewer->name,
                'xp' => $viewer->xp,
                'watch_minutes' => $viewer->total_watch_minutes,
                'streak' => $viewer->current_streak,
                'badge_count' => $viewer->badges_count,
                'badges' => $badges,
            ],
        ]);
    }

    public function heartbeat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'viewer_id' => 'required|exists:viewers,id',
            'minutes' => 'required|integer|min:1|max:10',
        ]);

        $viewer = Viewer::findOrFail($validated['viewer_id']);
        $viewer->addWatchMinutes($validated['minutes']);

        $xpPerMinute = 1;
        $viewer->addXp($validated['minutes'] * $xpPerMinute);

        return response()->json([
            'success' => true,
            'total_minutes' => $viewer->total_watch_minutes,
            'xp' => $viewer->xp,
        ]);
    }

    public function share(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'shareable_type' => 'required|in:team,viewer',
            'shareable_id' => 'required|integer',
            'platform' => 'required|in:twitter,instagram,linkedin,tiktok,other',
            'share_url' => 'nullable|url',
        ]);

        $type = $validated['shareable_type'] === 'team'
            ? \App\Models\Team::class
            : Viewer::class;

        $points = config("livingcode.gamification.social_share_points.{$validated['platform']}", 10);

        $share = SocialShare::create([
            'shareable_type' => $type,
            'shareable_id' => $validated['shareable_id'],
            'platform' => $validated['platform'],
            'share_url' => $validated['share_url'] ?? null,
            'points_earned' => $points,
        ]);

        $entity = $type::find($validated['shareable_id']);
        if ($entity) {
            // Sadece izleyiciler XP kazanır, takımlar için XP yok
            if ($entity instanceof Viewer) {
                $entity->addXp($points);
            }

            $xpText = $entity instanceof Viewer ? " (+{$points} XP)" : '';
            LevelAnnouncement::create([
                'team_id' => $entity instanceof \App\Models\Team ? $entity->id : null,
                'viewer_id' => $entity instanceof Viewer ? $entity->id : null,
                'message' => "{$entity->name} sosyal medyada paylaşım yaptı!{$xpText}",
                'type' => 'social_share',
                'meta' => ['platform' => $validated['platform'], 'points' => $points],
            ]);
        }

        return response()->json(['success' => true, 'points_earned' => $points]);
    }

    /**
     * İzleyici XP talebi: Kanıt fotoğrafı ile sosyal paylaşım vb. Şura onayına gider.
     */
    public function claim(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'viewer_id' => 'required|exists:viewers,id',
            'platform' => 'required|in:twitter,instagram,linkedin,tiktok,other',
            'share_url' => 'nullable|url|max:500',
            'proof' => 'required|file|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $viewer = $request->input('authenticated_viewer') ?? Viewer::findOrFail($validated['viewer_id']);

        $file = $request->file('proof');
        $path = $file->store('viewer-claims', 'public');

        $points = (int) config("livingcode.gamification.social_share_points.{$validated['platform']}", 10);

        ViewerXpClaim::create([
            'viewer_id' => $viewer->id,
            'claim_type' => 'social_share',
            'platform' => $validated['platform'],
            'points_requested' => $points,
            'proof_path' => $path,
            'share_url' => $validated['share_url'] ?? null,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Talebiniz şura tarafından onay bekliyor. Onaylandığında ' . $points . ' XP eklenecektir.',
        ]);
    }
}
