{{-- Rozet Galerisi: Tüm rozetler, kilitli/açık, nadir seviyeler --}}
<section id="badges" class="section-sura py-16 sm:py-24 px-6 relative bg-dark-800/50">
    <div class="max-w-6xl mx-auto">
        <span class="section-voice-label text-amethyst-200/90 text-xs font-mono tracking-widest uppercase block mb-2 reveal">Rozetler</span>
        <h2 class="section-title-wraith text-2xl sm:text-3xl font-cinzel font-bold text-parchment-100 mb-2 reveal">
            Rozet Galerisi
        </h2>
        <p class="text-parchment-400 text-sm mb-4 reveal">Görevleri tamamla, rozetleri topla. Rakip takımlarla takas yap.</p>

        {{-- Rarity Filter --}}
        <div class="flex flex-wrap gap-2 mb-8 reveal" id="badge-filters">
            <button class="badge-filter active px-3 py-1.5 rounded-lg text-xs font-medium transition-all" data-rarity="all">Tümü</button>
            <button class="badge-filter px-3 py-1.5 rounded-lg text-xs font-medium transition-all" data-rarity="common">
                <span class="inline-block w-2 h-2 rounded-full bg-gray-400 mr-1"></span>Yaygın
            </button>
            <button class="badge-filter px-3 py-1.5 rounded-lg text-xs font-medium transition-all" data-rarity="rare">
                <span class="inline-block w-2 h-2 rounded-full bg-blue-400 mr-1"></span>Nadir
            </button>
            <button class="badge-filter px-3 py-1.5 rounded-lg text-xs font-medium transition-all" data-rarity="epic">
                <span class="inline-block w-2 h-2 rounded-full bg-purple-400 mr-1"></span>Epik
            </button>
            <button class="badge-filter px-3 py-1.5 rounded-lg text-xs font-medium transition-all" data-rarity="legendary">
                <span class="inline-block w-2 h-2 rounded-full bg-yellow-400 mr-1"></span>Efsanevi
            </button>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4" id="badge-grid">
            @foreach ($badges ?? [] as $badge)
            <div class="badge-item rounded-xl p-4 text-center border transition-all cursor-pointer {{ $badge['earned'] ?? false ? 'badge-earned' : 'badge-locked' }} badge-rarity-{{ $badge['rarity'] }}" data-rarity="{{ $badge['rarity'] }}" data-badge-id="{{ $badge['id'] }}">
                <div class="badge-icon text-4xl mb-2 {{ $badge['earned'] ?? false ? '' : 'grayscale opacity-40' }}">
                    {{ $badge['icon'] }}
                </div>
                <h4 class="font-cinzel font-bold text-sm {{ $badge['earned'] ?? false ? 'text-parchment-100' : 'text-parchment-300/50' }} mb-1 leading-tight">
                    {{ $badge['name'] }}
                </h4>
                <span class="badge-rarity-label text-[0.6rem] px-2 py-0.5 rounded-full font-mono uppercase {{ match($badge['rarity']) {
                    'common' => 'bg-gray-500/20 text-gray-400',
                    'rare' => 'bg-blue-500/20 text-blue-400',
                    'epic' => 'bg-purple-500/20 text-purple-400',
                    'legendary' => 'bg-yellow-500/20 text-yellow-400',
                    default => 'bg-white/10 text-parchment-300',
                } }}">{{ match($badge['rarity']) { 'common' => 'Yaygın', 'rare' => 'Nadir', 'epic' => 'Epik', 'legendary' => 'Efsanevi', default => '' } }}</span>
                <p class="text-parchment-300 text-[0.65rem] mt-2 leading-snug {{ $badge['earned'] ?? false ? '' : 'opacity-50' }}">
                    {{ $badge['description'] }}
                </p>
                @if($badge['is_tradeable'] ?? false)
                <span class="text-[0.55rem] text-amethyst-100/60 mt-1 block">🔄 Takas edilebilir</span>
                @endif
            </div>
            @endforeach
        </div>

        @if(empty($badges ?? []))
        <div class="text-center py-12 text-parchment-300 text-sm reveal">
            Rozet galerisi yükleniyor...
        </div>
        @endif
    </div>
</section>
