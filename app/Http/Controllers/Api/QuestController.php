<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quest;
use App\Models\QuestCompletion;
use App\Models\LevelAnnouncement;
use App\Models\Team;
use App\Models\Viewer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class QuestController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $quests = Quest::active()
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
                'difficulty_color' => $q->difficulty_color,
                'expires_at' => $q->expires_at->toIso8601String(),
                'remaining' => $q->remaining_time,
                'max_completions' => $q->max_completions,
                'current_completions' => $q->current_completions,
                'available' => $q->isAvailable(),
                'expiring_soon' => $q->expires_at->diffInMinutes(now()) <= 60,
            ]);

        return response()->json(['success' => true, 'data' => $quests]);
    }

    public function complete(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'completable_type' => 'required|in:team,viewer',
            'completable_id' => 'required|integer',
            'proof_url' => 'nullable|url',
        ]);

        return DB::transaction(function () use ($validated, $id) {
            $quest = Quest::lockForUpdate()->findOrFail($id);

            if (!$quest->isAvailable()) {
                return response()->json(['success' => false, 'error' => 'Bu görev artık mevcut değil.'], 422);
            }

            $type = $validated['completable_type'] === 'team'
                ? Team::class
                : Viewer::class;

            $existing = QuestCompletion::where('quest_id', $quest->id)
                ->where('completable_type', $type)
                ->where('completable_id', $validated['completable_id'])
                ->exists();

            if ($existing) {
                return response()->json(['success' => false, 'error' => 'Bu görevi zaten tamamladınız.'], 422);
            }

            $entity = $type::findOrFail($validated['completable_id']);

            QuestCompletion::create([
                'quest_id' => $quest->id,
                'completable_type' => $type,
                'completable_id' => $entity->id,
                'proof_url' => $validated['proof_url'] ?? null,
                'xp_earned' => $quest->xp_reward,
                'credits_earned' => $quest->credit_reward,
                'completed_at' => now(),
            ]);

            $quest->increment('current_completions');

            if ($entity instanceof Team) {
                if ($quest->credit_reward > 0 && $entity->hucre) {
                    $entity->hucre->increment('credits', $quest->credit_reward);
                }
                $xpEarned = 0;
            } else {
                $entity->addXp($quest->xp_reward);
                $xpEarned = $quest->xp_reward;
            }

            $entityName = $entity->name ?? 'Bilinmeyen';
            LevelAnnouncement::create([
                'team_id' => $entity instanceof Team ? $entity->id : null,
                'viewer_id' => $entity instanceof Viewer ? $entity->id : null,
                'message' => "{$entityName}, \"{$quest->title}\" görevini tamamladı!",
                'type' => 'quest_complete',
                'meta' => ['quest' => $quest->title, 'xp' => $xpEarned, 'credits' => $quest->credit_reward],
            ]);

            Cache::forget('page:quests');
            Cache::forget('page:feed');

            return response()->json(['success' => true, 'data' => ['xp_earned' => $xpEarned, 'credits_earned' => $quest->credit_reward]]);
        });
    }
}
