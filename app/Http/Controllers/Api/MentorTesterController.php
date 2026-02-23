<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LevelAnnouncement;
use App\Models\MentorRequest;
use App\Models\Team;
use App\Models\TesterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MentorTesterController extends Controller
{
    public function requestMentor(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'topic' => 'required|string|max:100',
            'details' => 'nullable|string|max:500',
        ]);

        $team = Team::findOrFail($validated['team_id']);

        $activeCount = MentorRequest::where('team_id', $team->id)
            ->active()
            ->count();

        if ($activeCount >= 2) {
            return response()->json(['success' => false, 'error' => 'Aynı anda en fazla 2 mentor talebi açabilirsiniz.'], 422);
        }

        $mentorRequest = MentorRequest::create([
            'team_id' => $team->id,
            'topic' => $validated['topic'],
            'details' => $validated['details'] ?? null,
            'status' => 'pending',
        ]);

        LevelAnnouncement::create([
            'team_id' => $team->id,
            'message' => "{$team->name} mentor desteği talep etti: {$validated['topic']}",
            'type' => 'system',
            'meta' => ['topic' => $validated['topic']],
        ]);

        return response()->json(['success' => true, 'data' => ['request_id' => $mentorRequest->id, 'team_id' => $team->id]]);
    }

    public function requestTester(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
        ]);

        $team = Team::with('hucre')->findOrFail($validated['team_id']);
        $creditCost = config('livingcode.gamification.tester_credit_cost', 50);

        if ($team->credits < $creditCost) {
            return response()->json(['success' => false, 'error' => "Tester çağırmak için en az {$creditCost} kredi gerekli."], 422);
        }

        $activeTester = TesterRequest::where('team_id', $team->id)
            ->active()
            ->exists();

        if ($activeTester) {
            return response()->json(['success' => false, 'error' => 'Zaten aktif bir tester talebiniz var.'], 422);
        }

        $team->spendCredits($creditCost);

        $testerRequest = TesterRequest::create([
            'team_id' => $team->id,
            'xp_cost' => 0,
            'status' => 'pending',
        ]);

        LevelAnnouncement::create([
            'team_id' => $team->id,
            'message' => "{$team->name} test ekibini çağırdı! ({$creditCost} kredi harcandı)",
            'type' => 'tester_called',
            'meta' => ['credit_cost' => $creditCost],
        ]);

        return response()->json(['success' => true, 'data' => ['request_id' => $testerRequest->id, 'team_id' => $team->id, 'remaining_credits' => $team->fresh()->credits]]);
    }

    public function mentorStatus(Request $request): JsonResponse
    {
        $teamId = $request->query('team_id');
        $requests = MentorRequest::where('team_id', $teamId)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(fn (MentorRequest $r) => [
                'id' => $r->id,
                'topic' => $r->topic,
                'status' => $r->status,
                'mentor_name' => $r->mentor_name,
                'created_at' => $r->created_at->diffForHumans(),
            ]);

        return response()->json(['success' => true, 'data' => $requests]);
    }

    public function testerStatus(Request $request): JsonResponse
    {
        $teamId = $request->query('team_id');
        $requests = TesterRequest::with('team:id,name')
            ->where('team_id', $teamId)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(fn (TesterRequest $r) => [
                'id' => $r->id,
                'team_name' => $r->team->name ?? 'Bilinmeyen',
                'status' => $r->status,
                'xp_cost' => $r->xp_cost,
                'feedback' => $r->feedback,
                'rating' => $r->rating,
                'created_at' => $r->created_at->diffForHumans(),
            ]);

        return response()->json(['success' => true, 'data' => $requests]);
    }
}
