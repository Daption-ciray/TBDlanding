{{-- Canlı Akış: Anlık seviye duyuruları, rozet, kart, görev --}}
<section id="live-feed" class="py-8 px-6 relative bg-dark-800/50 border-y border-white/5">
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-4 reveal">
            <div class="flex items-center gap-3">
                <span class="live-pulse w-2.5 h-2.5 rounded-full bg-red-500 inline-block"></span>
                <span class="text-parchment-100 font-cinzel font-bold text-sm tracking-wider uppercase">Canlı Akış</span>
            </div>
            <span class="text-parchment-400 text-xs font-mono">Takım &amp; izleyici sıralama güncellemeleri</span>
        </div>

        <div class="feed-container relative overflow-hidden rounded-xl border border-white/10 bg-white/[0.02]" style="max-height: 280px;" id="feed-scroll">
            <div class="feed-list space-y-0" id="feed-list">
                @forelse ($feedItems ?? [] as $item)
                <div class="feed-item flex items-start gap-3 px-4 py-3 border-b border-white/5 hover:bg-white/[0.02] transition-colors">
                    <span class="text-lg flex-shrink-0 mt-0.5">{{ $item['icon'] ?? '📌' }}</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-parchment-100 text-sm leading-snug">{{ $item['message'] }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            @if($item['team_name'] ?? false)
                            <span class="text-[0.65rem] px-1.5 py-0.5 rounded {{ ($item['team_role'] ?? '') === 'adem' ? 'bg-gold-400/50 text-gold-200' : 'bg-amethyst-300/50 text-amethyst-100' }}">{{ $item['team_name'] }}</span>
                            @endif
                            @if($item['viewer_name'] ?? false)
                            <span class="text-[0.65rem] px-1.5 py-0.5 rounded bg-amethyst-300/30 text-amethyst-100">👁️ {{ $item['viewer_name'] }}</span>
                            @endif
                            <span class="text-parchment-400 text-[0.65rem]">{{ $item['time_human'] ?? '' }}</span>
                        </div>
                    </div>
                    @php
                        $subtype = $item['meta']['subtype'] ?? null;
                        $isRank = $subtype === 'team_rank_change' || $subtype === 'viewer_rank_change';
                        $badgeLabel = $isRank ? 'sıralama' : match($item['type'] ?? 'system') {
                            'level_up' => 'seviye', 'badge_earned' => 'rozet', 'quest_complete' => 'görev',
                            'card_used' => 'kart', 'tester_called' => 'test', 'trade_complete' => 'takas',
                            'social_share' => 'paylaşım', default => 'sistem',
                        };
                        $badgeClass = $isRank ? 'bg-gold-400/30 text-gold-200' : match($item['type'] ?? 'system') {
                            'level_up' => 'bg-gold-400/30 text-gold-200', 'badge_earned' => 'bg-amethyst-300/30 text-amethyst-100',
                            'quest_complete' => 'bg-green-500/20 text-green-400', 'card_used' => 'bg-red-500/20 text-red-400',
                            'tester_called' => 'bg-cyan-500/20 text-cyan-400', 'trade_complete' => 'bg-blue-500/20 text-blue-400',
                            'social_share' => 'bg-pink-500/20 text-pink-400', default => 'bg-white/10 text-parchment-300',
                        };
                    @endphp
                    <span class="feed-type-badge text-[0.6rem] px-2 py-0.5 rounded-full font-mono uppercase tracking-wider {{ $badgeClass }}">{{ $badgeLabel }}</span>
                </div>
                @empty
                <div class="text-center py-8 text-parchment-300 text-sm" id="feed-empty">
                    Henüz duyuru yok. Etkinlik başladığında canlı akış burada olacak!
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
