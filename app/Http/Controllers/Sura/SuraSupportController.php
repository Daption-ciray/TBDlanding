<?php

namespace App\Http\Controllers\Sura;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\Card;
use App\Models\LevelAnnouncement;
use App\Models\MentorRequest;
use App\Models\Quest;
use App\Models\TesterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuraSupportController extends Controller
{
    public function quests(): View
    {
        $quests = Quest::withCount('completions')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('sura.quests', ['quests' => $quests]);
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

    public function storeQuest(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'required|string|max:1000',
            'type' => 'required|in:team,viewer,both',
            'xp_reward' => 'required|integer|min:0|max:500',
            'credit_reward' => 'nullable|integer|min:0|max:500',
            'starts_at' => 'required|date',
            'expires_at' => 'required|date|after:starts_at',
            'max_completions' => 'required|integer|min:0',
            'difficulty' => 'required|in:easy,medium,hard',
            'icon' => 'nullable|string|max:10',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']);
        $validated['credit_reward'] = $validated['credit_reward'] ?? 0;
        $validated['icon'] = $validated['icon'] ?? '⚡';
        $validated['is_active'] = true;
        $validated['current_completions'] = 0;

        $quest = Quest::create($validated);

        return response()->json(['success' => true, 'quest' => [
            'id' => $quest->id,
            'title' => $quest->title,
        ]], 201);
    }

    public function updateQuest(Request $request, int $id): JsonResponse
    {
        $quest = Quest::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'required|string|max:1000',
            'type' => 'required|in:team,viewer,both',
            'xp_reward' => 'required|integer|min:0|max:500',
            'credit_reward' => 'nullable|integer|min:0|max:500',
            'expires_at' => 'required|date',
            'max_completions' => 'required|integer|min:0',
            'difficulty' => 'required|in:easy,medium,hard',
            'is_active' => 'nullable|boolean',
        ]);

        $quest->update($validated);

        return response()->json(['success' => true]);
    }

    public function destroyQuest(int $id): JsonResponse
    {
        Quest::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function storeBadge(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'icon' => 'required|string|max:10',
            'type' => 'required|in:team,viewer,sponsor,special',
            'rarity' => 'required|in:common,rare,epic,legendary',
            'is_tradeable' => 'nullable|boolean',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        $validated['is_tradeable'] = $validated['is_tradeable'] ?? false;

        $badge = Badge::create($validated);

        return response()->json(['success' => true, 'badge' => [
            'id' => $badge->id,
            'name' => $badge->name,
        ]], 201);
    }

    public function storeCard(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'effect_description' => 'required|string|max:500',
            'type' => 'required|in:lutuf,gazap',
            'rarity' => 'required|in:common,rare,epic,legendary',
            'cost_credits' => 'required|integer|min:1|max:500',
            'stock' => 'required|integer|min:0|max:999',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        $validated['is_active'] = true;

        $card = Card::create($validated);

        return response()->json(['success' => true, 'card' => [
            'id' => $card->id,
            'name' => $card->name,
        ]], 201);
    }

    public function updateCard(Request $request, int $id): JsonResponse
    {
        $card = Card::findOrFail($id);
        $validated = $request->validate([
            'stock' => 'nullable|integer|min:0|max:999',
            'cost_credits' => 'nullable|integer|min:1|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        $card->update($validated);

        return response()->json(['success' => true]);
    }
}
