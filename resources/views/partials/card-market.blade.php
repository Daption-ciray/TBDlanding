{{-- Kart Pazarı: Lütuf & Gazap kartları --}}
<section id="card-market" class="section-hucre py-16 sm:py-24 px-6 relative bg-dark-900">
    <div class="max-w-6xl mx-auto">
        <span class="section-voice-label text-gold-300 text-xs font-mono tracking-widest uppercase block mb-2 reveal">Şura Pazarı</span>
        <h2 class="section-title-wraith text-2xl sm:text-3xl font-cinzel font-bold text-parchment-100 mb-2 reveal">
            Müdahale Kartları
        </h2>
        <p class="text-parchment-400 text-sm mb-4 reveal">Kredi harcayarak kart satın al. Kendine buff sağla ya da rakibini sabote et.</p>

        {{-- Recent purchases ticker --}}
        <div class="mb-8 reveal">
            <div class="card-ticker flex items-center gap-2 px-4 py-2 rounded-lg border border-white/5 bg-white/[0.02] overflow-hidden" id="card-ticker">
                <span class="text-parchment-400 text-xs flex-shrink-0">Son İşlemler:</span>
                <div class="card-ticker-content text-xs text-parchment-300 whitespace-nowrap" id="card-ticker-content">
                    Henüz işlem yok
                </div>
            </div>
        </div>

        {{-- Card Type Tabs --}}
        <div class="flex gap-2 mb-8 reveal" id="card-tabs">
            <button class="card-tab active px-5 py-2.5 rounded-lg text-sm font-medium transition-all" data-type="all">
                🃏 Tümü
            </button>
            <button class="card-tab px-5 py-2.5 rounded-lg text-sm font-medium transition-all" data-type="lutuf">
                ✨ Lütuf Kartları
            </button>
            <button class="card-tab px-5 py-2.5 rounded-lg text-sm font-medium transition-all" data-type="gazap">
                ⚡ Gazap Kartları
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="card-grid">
            @foreach ($cards ?? [] as $card)
            <div class="card-flip-container perspective-1000 {{ $card['available'] ?? true ? '' : 'opacity-50' }}" data-card-type="{{ $card['type'] }}">
                <div class="card-flip relative transition-transform duration-500 cursor-pointer" style="transform-style: preserve-3d;" data-card-id="{{ $card['id'] }}">
                    {{-- Card Front --}}
                    <div class="card-front rounded-xl p-6 border {{ $card['type'] === 'lutuf' ? 'border-gold-200/20 bg-gradient-to-br from-gold-400/10 to-transparent' : 'border-red-500/20 bg-gradient-to-br from-red-500/10 to-transparent' }}">
                        <div class="flex items-start justify-between mb-4">
                            <span class="card-rarity-badge text-[0.6rem] px-2 py-0.5 rounded-full font-mono uppercase {{ match($card['rarity'] ?? 'common') {
                                'common' => 'bg-gray-500/20 text-gray-400',
                                'rare' => 'bg-blue-500/20 text-blue-400',
                                'epic' => 'bg-purple-500/20 text-purple-400',
                                'legendary' => 'bg-yellow-500/20 text-yellow-400',
                                default => 'bg-white/10 text-parchment-300',
                            } }}">{{ match($card['rarity'] ?? 'common') { 'common' => 'Yaygın', 'rare' => 'Nadir', 'epic' => 'Epik', 'legendary' => 'Efsanevi', default => '' } }}</span>
                            <span class="text-2xl">{{ $card['type'] === 'lutuf' ? '✨' : '⚡' }}</span>
                        </div>

                        <h4 class="font-cinzel font-bold text-lg {{ $card['type'] === 'lutuf' ? 'text-gold-100' : 'text-red-400' }} mb-2">
                            {{ $card['name'] }}
                        </h4>
                        <p class="text-parchment-200 text-sm leading-relaxed mb-4">{{ $card['description'] }}</p>

                        <div class="flex items-center justify-between mt-auto">
                            <div class="flex items-center gap-1">
                                <span class="text-gold-200 font-mono font-bold">{{ $card['cost'] }}</span>
                                <span class="text-parchment-300 text-xs">Kredi</span>
                            </div>
                            <div class="flex items-center gap-1 text-xs text-parchment-400">
                                <span>Stok:</span>
                                <span class="font-mono {{ ($card['stock'] ?? 0) <= 3 ? 'text-red-400' : 'text-parchment-200' }}">{{ $card['stock'] ?? 0 }}</span>
                            </div>
                        </div>

                        <p class="text-parchment-300 text-[0.65rem] mt-3 text-center">Etkisini görmek için kartın üzerine gel</p>
                    </div>

                    {{-- Card Back (Effect) --}}
                    <div class="card-back absolute inset-0 rounded-xl p-6 border {{ $card['type'] === 'lutuf' ? 'border-gold-200/30 bg-dark-800' : 'border-red-500/30 bg-dark-800' }}" style="backface-visibility: hidden; transform: rotateY(180deg);">
                        <div class="h-full flex flex-col justify-center text-center">
                            <span class="text-3xl mb-3">{{ $card['type'] === 'lutuf' ? '✨' : '💀' }}</span>
                            <h4 class="font-cinzel font-bold text-lg {{ $card['type'] === 'lutuf' ? 'text-gold-100' : 'text-red-400' }} mb-3">Etki</h4>
                            <p class="text-parchment-100 text-sm leading-relaxed">{{ $card['effect'] ?? '' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if(empty($cards ?? []))
        <div class="text-center py-12 text-parchment-300 text-sm reveal">
            Kart pazarı İmtihan fazında açılacak!
        </div>
        @endif
    </div>
</section>
