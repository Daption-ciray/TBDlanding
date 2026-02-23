<?php

namespace App\Http\Controllers\Sura;

use App\Http\Controllers\Controller;
use App\Models\Hucre;
use App\Models\LevelAnnouncement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuraHucreController extends Controller
{
    public function index(): View
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

    public function store(Request $request): JsonResponse
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

    public function update(Request $request, int $id): JsonResponse
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

    public function destroy(int $id): JsonResponse
    {
        $hucre = Hucre::findOrFail($id);
        $hucreName = $hucre->name;

        $hucre->teams()->update(['hucre_id' => null]);
        $hucre->delete();

        LevelAnnouncement::create([
            'message' => "{$hucreName} hücresi silindi.",
            'type' => 'system',
        ]);

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
}
