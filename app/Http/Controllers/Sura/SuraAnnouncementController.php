<?php

namespace App\Http\Controllers\Sura;

use App\Http\Controllers\Controller;
use App\Models\LevelAnnouncement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuraAnnouncementController extends Controller
{
    public function index(): View
    {
        $announcements = LevelAnnouncement::with(['team:id,name', 'viewer:id,name'])
            ->orderByDesc('created_at')
            ->paginate(30);

        return view('sura.announcements', ['announcements' => $announcements]);
    }

    public function viewerAnnouncements(): View
    {
        $announcements = LevelAnnouncement::with(['viewer:id,name,email'])
            ->whereNotNull('viewer_id')
            ->orderByDesc('created_at')
            ->paginate(30);

        return view('sura.viewer-announcements', ['announcements' => $announcements]);
    }

    public function store(Request $request): JsonResponse
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

    public function update(Request $request, int $id): JsonResponse
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

    public function destroy(int $id): JsonResponse
    {
        LevelAnnouncement::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
