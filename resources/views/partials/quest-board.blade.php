{{-- Görev Tahtası: Kısa süreli görevler --}}
<section id="quests" class="section-hucre py-16 sm:py-24 px-6 relative bg-dark-900">
    <div class="max-w-6xl mx-auto">
        <span class="section-voice-label text-gold-300 text-xs font-mono tracking-widest uppercase block mb-2 reveal">Görevler</span>
        <h2 class="section-title-wraith text-2xl sm:text-3xl font-cinzel font-bold text-parchment-100 mb-2 reveal">
            Görev Tahtası
        </h2>
        <p class="text-parchment-400 text-sm mb-8 reveal">Kısa süreli görevleri tamamla, XP ve kredi kazan.</p>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" id="quest-board">
            {{-- Team Quests Column --}}
            <div>
                <h3 class="text-gold-200 font-cinzel font-bold text-lg mb-4 reveal flex items-center gap-2">
                    🏰 Hücre Görevleri
                </h3>
                <div class="space-y-4" id="quest-team-list">
                    @forelse (($quests ?? collect())->where('type', '!=', 'viewer') as $quest)
                    <div class="quest-card rounded-xl p-5 border border-white/10 bg-white/[0.03] transition-all hover:border-gold-200/20 {{ $quest['expiring_soon'] ?? false ? 'quest-expiring' : '' }}">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <span class="text-2xl">{{ $quest['icon'] }}</span>
                                <div>
                                    <h4 class="font-cinzel font-bold text-parchment-100">{{ $quest['title'] }}</h4>
                                    <span class="quest-difficulty text-[0.6rem] px-2 py-0.5 rounded-full font-mono uppercase {{ match($quest['difficulty'] ?? 'medium') {
                                        'easy' => 'bg-green-500/20 text-green-400',
                                        'medium' => 'bg-gold-400/30 text-gold-200',
                                        'hard' => 'bg-red-500/20 text-red-400',
                                        default => 'bg-white/10 text-parchment-300',
                                    } }}">{{ match($quest['difficulty'] ?? 'medium') { 'easy' => 'Kolay', 'medium' => 'Orta', 'hard' => 'Zor', default => 'Orta' } }}</span>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                @if(($quest['credit_reward'] ?? 0) > 0)
                                <span class="text-amethyst-100 font-mono font-bold text-sm">+{{ $quest['credit_reward'] }} Kredi</span>
                                @else
                                <span class="text-gold-200 font-mono text-xs">Görev tamamlandı</span>
                                @endif
                            </div>
                        </div>
                        <p class="text-parchment-200 text-sm mb-3">{{ $quest['description'] }}</p>
                        <div class="flex items-center justify-between">
                            <div class="quest-timer flex items-center gap-1.5 text-xs" data-expires="{{ $quest['expires_at'] ?? '' }}">
                                <svg class="w-3.5 h-3.5 text-parchment-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="text-parchment-300 quest-time-remaining">{{ $quest['remaining'] ?? '' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="quest-progress-bar w-20 h-1.5 rounded-full bg-white/10 overflow-hidden">
                                    <div class="h-full rounded-full bg-gold-200 transition-all" style="width: {{ $quest['max_completions'] > 0 ? min(100, ($quest['current_completions'] / $quest['max_completions']) * 100) : 0 }}%"></div>
                                </div>
                                <span class="text-parchment-400 text-[0.6rem]">{{ $quest['current_completions'] }}/{{ $quest['max_completions'] }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-parchment-300 text-sm rounded-xl border border-white/5 bg-white/[0.02]">
                        Aktif Hücre görevi yok.
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Viewer Quests Column --}}
            <div>
                <h3 class="text-amethyst-100 font-cinzel font-bold text-lg mb-4 reveal flex items-center gap-2">
                    👁️ İzleyici Görevleri
                </h3>
                <div class="space-y-4" id="quest-viewer-list">
                    @forelse (($quests ?? collect())->where('type', '!=', 'team') as $quest)
                    <div class="quest-card rounded-xl p-5 border border-white/10 bg-white/[0.03] transition-all hover:border-amethyst-100/20 {{ $quest['expiring_soon'] ?? false ? 'quest-expiring' : '' }}">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <span class="text-2xl">{{ $quest['icon'] }}</span>
                                <div>
                                    <h4 class="font-cinzel font-bold text-parchment-100">{{ $quest['title'] }}</h4>
                                    <span class="quest-difficulty text-[0.6rem] px-2 py-0.5 rounded-full font-mono uppercase {{ match($quest['difficulty'] ?? 'medium') {
                                        'easy' => 'bg-green-500/20 text-green-400',
                                        'medium' => 'bg-gold-400/30 text-gold-200',
                                        'hard' => 'bg-red-500/20 text-red-400',
                                        default => 'bg-white/10 text-parchment-300',
                                    } }}">{{ match($quest['difficulty'] ?? 'medium') { 'easy' => 'Kolay', 'medium' => 'Orta', 'hard' => 'Zor', default => 'Orta' } }}</span>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <span class="text-amethyst-100 font-mono font-bold text-sm">+{{ $quest['xp_reward'] }} XP</span>
                            </div>
                        </div>
                        <p class="text-parchment-200 text-sm mb-3">{{ $quest['description'] }}</p>
                        <div class="flex items-center justify-between">
                            <div class="quest-timer flex items-center gap-1.5 text-xs" data-expires="{{ $quest['expires_at'] ?? '' }}">
                                <svg class="w-3.5 h-3.5 text-parchment-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="text-parchment-300 quest-time-remaining">{{ $quest['remaining'] ?? '' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="quest-progress-bar w-20 h-1.5 rounded-full bg-white/10 overflow-hidden">
                                    <div class="h-full rounded-full bg-amethyst-100 transition-all" style="width: {{ $quest['max_completions'] > 0 ? min(100, ($quest['current_completions'] / $quest['max_completions']) * 100) : 0 }}%"></div>
                                </div>
                                <span class="text-parchment-400 text-[0.6rem]">{{ $quest['current_completions'] }}/{{ $quest['max_completions'] }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-parchment-300 text-sm rounded-xl border border-white/5 bg-white/[0.02]">
                        Aktif izleyici görevi yok.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
