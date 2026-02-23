@php $role = $role ?? 'adem'; @endphp
<section
    id="konsept"
    class="section-hucre py-16 sm:py-24 px-6 relative {{ $role === 'baba' ? 'bg-[#020617] baba-theme' : 'bg-dark-800/50' }}"
>
    <div class="max-w-6xl mx-auto">
        <span class="section-voice-label text-gold-300 text-xs font-mono tracking-widest uppercase block mb-2 reveal">Konsept</span>
        <h2 class="section-title-wraith text-2xl sm:text-3xl font-cinzel font-bold text-parchment-100 mb-2 reveal">
            Kaotik Uyum
        </h2>
        <p class="text-parchment-400 text-sm mb-6 reveal">
            Zıt iki kavramı tek oyunda birleştir. Denge kuran kazanır.
        </p>

        {{-- Rol toggle --}}
        <div class="flex items-center justify-center gap-3 mb-10 reveal">
            <a href="?role=adem" class="role-toggle-btn px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $role === 'adem' ? 'bg-gold-400 text-parchment-100 border border-gold-300/40' : 'bg-white/5 text-parchment-300 border border-white/10 hover:border-gold-300/30' }}">
                🔥 ADEM
            </a>
            <a href="?role=baba" class="role-toggle-btn px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $role === 'baba' ? 'bg-parchment-100 text-gold-200 border border-gold-300/40' : 'bg-white/5 text-parchment-300 border border-white/10 hover:border-parchment-300/40' }}">
                🛡️ BABA
            </a>
            <span class="text-parchment-400 text-xs ml-2 hidden sm:inline">← tarafını seç</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div class="role-card role-card-adem rounded-2xl p-8 reveal flex flex-col md:flex-row md:items-end gap-6">
                {{-- Sol tarafta insan/karakter alanı --}}
                <div class="role-card-figure flex-shrink-0 w-32 h-40 md:w-36 md:h-44 flex items-end justify-center bg-gold-400/10 rounded-xl overflow-hidden">
                    @php $ademImg = 'images/adem_figure.png'; $ademExists = file_exists(public_path($ademImg)); @endphp
                    @if($ademExists)
                        <img src="{{ asset($ademImg) }}" alt="ADEM — Kaşif" class="w-full h-full object-contain object-bottom">
                    @else
                        <span class="text-5xl opacity-50 mb-2">🔥</span>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-14 h-14 rounded-2xl bg-gold-400 border border-gold-300/30 flex items-center justify-center text-3xl">🔥</div>
                        <div>
                            <h3 class="font-cinzel text-gold-100 text-2xl font-bold tracking-wide">ADEM</h3>
                            <span class="text-gold-300 text-xs font-cinzel tracking-[0.25em]">KAŞİF</span>
                        </div>
                    </div>
                    <p class="text-parchment-200 leading-relaxed mb-5">
                        Deneysel, risk alan. Prototipleme, oynanış, iterasyon.
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1.5 rounded-lg text-xs bg-gold-400 text-gold-200 border border-gold-300/20 font-medium">İnovasyon</span>
                        <span class="px-3 py-1.5 rounded-lg text-xs bg-gold-400 text-gold-200 border border-gold-300/20 font-medium">Prototipleme</span>
                    </div>
                </div>
            </div>

            <div class="role-card role-card-baba rounded-2xl p-8 reveal reveal-delay-1 flex flex-col md:flex-row-reverse md:items-end gap-6">
                {{-- Sağ tarafta insan/karakter alanı --}}
                <div class="role-card-figure flex-shrink-0 w-32 h-40 md:w-36 md:h-44 flex items-end justify-center bg-dark-700 rounded-xl overflow-hidden">
                    @php $babaImg = 'images/baba_figure.png'; $babaExists = file_exists(public_path($babaImg)); @endphp
                    @if($babaExists)
                        <img src="{{ asset($babaImg) }}" alt="BABA — Mimar" class="w-full h-full object-contain object-bottom">
                    @else
                        <span class="text-5xl opacity-60 mb-2">🛡️</span>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-14 h-14 rounded-2xl bg-parchment-100 border border-gold-300/40 flex items-center justify-center text-3xl text-gold-200">🛡️</div>
                        <div>
                            <h3 class="font-cinzel text-parchment-100 text-2xl font-bold tracking-wide">BABA</h3>
                            <span class="text-parchment-300 text-xs font-cinzel tracking-[0.25em]">MİMAR</span>
                        </div>
                    </div>
                    <p class="text-parchment-200 leading-relaxed mb-5">
                        Mimari ve bütünlük. Kod kalitesi, sürdürülebilirlik.
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1.5 rounded-lg text-xs bg-parchment-100/60 text-gold-200 border border-gold-300/50 font-medium">Mimari</span>
                        <span class="px-3 py-1.5 rounded-lg text-xs bg-parchment-100/60 text-gold-200 border border-gold-300/50 font-medium">Strateji</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="info-card rounded-2xl p-7 text-center reveal border-amethyst-100/20 bg-amethyst-300/5">
                <span class="section-voice-label text-amethyst-200/80 text-[0.65rem] font-mono tracking-widest uppercase block mb-2">Konsey</span>
                <div class="text-4xl mb-4">⚖️</div>
                <h3 class="font-cinzel text-amethyst-100 text-xl font-bold mb-3">ŞURA</h3>
                <p class="text-parchment-200 text-sm leading-relaxed mt-2">
                    Evrenin hakemi. Hücreleri denetler, müdahale kartları dağıtır.
                </p>
            </div>

            <div class="info-card rounded-2xl p-7 reveal reveal-delay-1">
                <div class="text-4xl mb-4">🃏</div>
                <h3 class="font-cinzel text-gold-100 text-xl font-bold mb-3">Müdahale Kartları</h3>
                <p class="text-parchment-300 text-xs">Lütuf (destek) ve Gazap (sabotaj). Kredi ile alınır.</p>
            </div>

            <div class="info-card rounded-2xl p-7 reveal reveal-delay-2">
                <div class="text-4xl mb-4">🤝</div>
                <h3 class="font-cinzel text-gold-100 text-xl font-bold mb-3">Diplomasi Masası</h3>
                <p class="text-parchment-200 text-sm leading-relaxed">Hücreler arası strateji. Mahkûm İkilemi.</p>
            </div>
        </div>
    </div>
</section>
