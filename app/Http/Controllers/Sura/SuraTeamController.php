<?php

namespace App\Http\Controllers\Sura;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\Hucre;
use App\Models\LevelAnnouncement;
use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SuraTeamController extends Controller
{
    public function index(Request $request): View
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

    public function store(Request $request): JsonResponse
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

    public function update(Request $request, int $id): JsonResponse
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

    public function destroy(int $id): JsonResponse
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
}
