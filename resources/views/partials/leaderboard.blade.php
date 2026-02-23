{{-- Liderlik Tablosu: Takımlar / Katılımcılar / İzleyiciler --}}
<section id="leaderboard" class="section-hucre py-16 sm:py-24 px-6 relative bg-dark-900">
    <div class="max-w-5xl mx-auto">
        <span class="section-voice-label text-gold-300 text-xs font-mono tracking-widest uppercase block mb-2 reveal">Liderlik</span>
        <h2 class="section-title-wraith text-2xl sm:text-3xl font-cinzel font-bold text-parchment-100 mb-2 reveal">
            Liderlik Tablosu
        </h2>
        <p class="text-parchment-400 text-sm mb-8 reveal">Evrende kim önde? Anlık sıralama.</p>

        {{-- Tab Navigation --}}
        <div class="flex gap-2 mb-8 reveal" id="lb-tabs">
            <button class="lb-tab active px-5 py-2.5 rounded-lg text-sm font-medium transition-all" data-tab="teams">
                🏆 Hücreler
            </button>
            <button class="lb-tab px-5 py-2.5 rounded-lg text-sm font-medium transition-all" data-tab="participants">
                👤 Katılımcılar
            </button>
            <button class="lb-tab px-5 py-2.5 rounded-lg text-sm font-medium transition-all" data-tab="viewers">
                👁️ İzleyiciler
            </button>
        </div>

        {{-- Leaderboard Content --}}
        <div class="leaderboard-container reveal">
            {{-- Teams Tab --}}
            <div class="lb-panel active" id="lb-teams">
                <div class="space-y-3" id="lb-teams-list">
                    @forelse ($leaderboardTeams ?? [] as $i => $team)
                    <div class="leaderboard-row flex items-center gap-4 p-4 rounded-xl border border-white/10 bg-white/[0.03] hover:border-gold-200/20 transition-all {{ $i < 3 ? 'leaderboard-top-' . ($i + 1) : '' }}">
                        <div class="rank-badge w-10 h-10 rounded-full flex items-center justify-center font-cinzel font-bold text-sm {{ $i === 0 ? 'bg-gold-400 text-gold-200' : ($i === 1 ? 'bg-parchment-300/20 text-parchment-200' : ($i === 2 ? 'bg-amber-900/30 text-amber-400' : 'bg-white/5 text-parchment-300')) }}">
                            {{ $i + 1 }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="font-cinzel font-bold text-parchment-100 truncate">{{ $team['name'] }}</span>
                                <span class="px-2 py-0.5 rounded text-[0.6rem] font-mono {{ $team['role'] === 'adem' ? 'bg-gold-400 text-gold-200' : 'bg-amethyst-300 text-amethyst-100' }}">
                                    {{ strtoupper($team['role']) }}
                                </span>
                            </div>
                            <div class="flex items-center gap-3 mt-1 text-xs text-parchment-300">
                                <span>{{ $team['badge_count'] ?? 0 }} rozet</span>
                                <span>{{ $team['supporter_count'] ?? 0 }} destekçi</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="font-mono font-bold text-lg {{ $team['role'] === 'adem' ? 'text-gold-200' : 'text-amethyst-100' }}">{{ number_format($team['supporter_count'] ?? 0) }}</span>
                            <span class="text-parchment-300 text-xs block">Destekçi</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12 text-parchment-300 text-sm">
                        Henüz sıralama verisi yok. Etkinlik başladığında burada olacak!
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Participants Tab --}}
            <div class="lb-panel" id="lb-participants">
                <div class="space-y-3" id="lb-participants-list">
                    @forelse ($leaderboardParticipants ?? [] as $i => $p)
                    <div class="leaderboard-row flex items-center gap-4 p-4 rounded-xl border border-white/10 bg-white/[0.03] hover:border-gold-200/20 transition-all">
                        <div class="rank-badge w-10 h-10 rounded-full flex items-center justify-center font-cinzel font-bold text-sm {{ $i === 0 ? 'bg-gold-400 text-gold-200' : 'bg-white/5 text-parchment-300' }}">
                            {{ $i + 1 }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <span class="font-cinzel font-bold text-parchment-100 truncate block">{{ $p['name'] }}</span>
                            <span class="text-parchment-300 text-xs">{{ $p['team_name'] ?? '' }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-parchment-300 text-xs">{{ $p['role_in_team'] ?? '' }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12 text-parchment-300 text-sm">Katılımcı verisi bekleniyor.</div>
                    @endforelse
                </div>
            </div>

            {{-- Viewers Tab --}}
            <div class="lb-panel" id="lb-viewers">
                <div class="space-y-3" id="lb-viewers-list">
                    @forelse ($leaderboardViewers ?? [] as $i => $v)
                    <div class="leaderboard-row flex items-center gap-4 p-4 rounded-xl border border-white/10 bg-white/[0.03] hover:border-amethyst-100/20 transition-all">
                        <div class="rank-badge w-10 h-10 rounded-full flex items-center justify-center font-cinzel font-bold text-sm {{ $i === 0 ? 'bg-amethyst-300 text-amethyst-100' : 'bg-white/5 text-parchment-300' }}">
                            {{ $i + 1 }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <span class="font-cinzel font-bold text-parchment-100 truncate block">{{ $v['name'] }}</span>
                            <span class="text-parchment-300 text-xs">{{ $v['watch_minutes'] ?? 0 }} dk izleme</span>
                        </div>
                        <div class="text-right">
                            <span class="font-mono font-bold text-lg text-amethyst-100">{{ number_format($v['xp']) }}</span>
                            <span class="text-parchment-300 text-xs block">XP</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12 text-parchment-300 text-sm">İzleyici sıralaması bekleniyor.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <p class="text-parchment-400 text-xs mt-4 text-center reveal">Her 30 saniyede otomatik güncellenir</p>
    </div>
</section>
