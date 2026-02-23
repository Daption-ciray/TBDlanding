<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\CardPurchase;
use App\Models\LevelAnnouncement;
use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    public function index(): JsonResponse
    {
        $cards = Card::active()
            ->orderBy('type')
            ->orderBy('cost_credits')
            ->get()
            ->map(fn (Card $c) => [
                'id' => $c->id,
                'name' => $c->name,
                'slug' => $c->slug,
                'type' => $c->type,
                'description' => $c->description,
                'effect' => $c->effect_description,
                'cost' => $c->cost_credits,
                'rarity' => $c->rarity,
                'stock' => $c->stock,
                'available' => $c->isAvailable(),
            ]);

        $recentPurchases = CardPurchase::with(['team:id,name', 'card:id,name,type', 'targetTeam:id,name'])
            ->orderByDesc('purchased_at')
            ->limit(5)
            ->get()
            ->map(fn (CardPurchase $cp) => [
                'team' => $cp->team->name ?? '',
                'card' => $cp->card->name ?? '',
                'type' => $cp->card->type ?? '',
                'target' => $cp->targetTeam->name ?? null,
                'time' => $cp->purchased_at?->diffForHumans(),
            ]);

        return response()->json([
            'success' => true,
            'data' => [
                'cards' => $cards,
                'recent_purchases' => $recentPurchases,
            ],
        ]);
    }

    public function purchase(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'card_id' => 'required|exists:cards,id',
            'target_team_id' => 'nullable|exists:teams,id',
        ]);

        return DB::transaction(function () use ($validated) {
            $team = Team::with('hucre')->findOrFail($validated['team_id']);
            $card = Card::lockForUpdate()->findOrFail($validated['card_id']);

            if (!$card->isAvailable()) {
                return response()->json(['success' => false, 'error' => 'Bu kart şu anda mevcut değil.'], 422);
            }

            if (!$team->spendCredits($card->cost_credits)) {
                return response()->json(['success' => false, 'error' => 'Yeterli krediniz yok.'], 422);
            }

            $card->decrement('stock');

            $purchase = CardPurchase::create([
                'team_id' => $team->id,
                'card_id' => $card->id,
                'target_team_id' => $validated['target_team_id'] ?? null,
                'credits_spent' => $card->cost_credits,
                'purchased_at' => now(),
            ]);

            $targetName = isset($validated['target_team_id'])
                ? Team::find($validated['target_team_id'])?->name ?? 'bilinmeyen'
                : null;

            $message = $card->type === 'gazap'
                ? "{$team->name}, {$card->name} kartını {$targetName}'a kullandı!"
                : "{$team->name}, {$card->name} kartını satın aldı!";

            LevelAnnouncement::create([
                'team_id' => $team->id,
                'message' => $message,
                'type' => 'card_used',
                'meta' => ['card' => $card->name, 'card_type' => $card->type, 'target' => $targetName],
            ]);

            Cache::forget('page:cards');

            $remainingCredits = $team->hucre ? $team->hucre->fresh()->credits : 0;
            return response()->json(['success' => true, 'data' => ['purchase_id' => $purchase->id, 'remaining_credits' => $remainingCredits]]);
        });
    }

    public function use(Request $request, int $id): JsonResponse
    {
        $purchase = CardPurchase::with('card', 'team')->findOrFail($id);

        if ($purchase->isUsed()) {
            return response()->json(['success' => false, 'error' => 'Bu kart zaten kullanılmış.'], 422);
        }

        $purchase->update([
            'used_at' => now(),
            'target_team_id' => $request->input('target_team_id', $purchase->target_team_id),
        ]);

        return response()->json(['success' => true, 'data' => []]);
    }
}
