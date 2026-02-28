@php $role = $role ?? 'kasif'; @endphp
<section
    id="konsept"
    class="section-hucre py-8 sm:py-12 px-6 relative {{ $role === 'mimar' ? 'bg-[#020617] mimar-theme' : 'bg-dark-800/50' }}"
>
    <div class="max-w-6xl mx-auto">
        {{-- Puanlama Şeması --}}
        <div class="mb-24">
            <span class="section-voice-label {{ $role === 'mimar' ? 'text-amethyst-300' : 'text-gold-300' }} text-xs font-mono tracking-widest uppercase block mb-2 reveal text-center">Değerlendirme Sistemi</span>
            <h2 class="section-title-wraith text-2xl sm:text-3xl font-cinzel font-bold text-parchment-100 mb-8 reveal text-center">
                Puanlama Şeması
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="info-card rounded-2xl p-6 reveal">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="text-3xl">⚖️</span>
                        <h3 class="font-cinzel {{ $role === 'mimar' ? 'text-amethyst-100' : 'text-gold-100' }} text-xl font-bold">Jüri Oyu</h3>
                    </div>
                    <div class="text-4xl font-bold {{ $role === 'mimar' ? 'text-amethyst-200' : 'text-gold-200' }} mb-2">%60</div>
                    <p class="text-parchment-300 text-xs leading-relaxed">
                        Ürün mantığı, teknik uygulama, yenilik ve sunum kalitesi Konsey tarafından puanlanır.
                    </p>
                </div>
                <div class="info-card rounded-2xl p-6 reveal reveal-delay-1">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="text-3xl">👥</span>
                        <h3 class="font-cinzel {{ $role === 'mimar' ? 'text-amethyst-100' : 'text-gold-100' }} text-xl font-bold">Seyirci Oyu</h3>
                    </div>
                    <div class="text-4xl font-bold {{ $role === 'mimar' ? 'text-amethyst-200' : 'text-gold-200' }} mb-2">%25</div>
                    <p class="text-parchment-300 text-xs leading-relaxed">
                        Etkinlik alanındaki izleyicilerin eğlence ve vibe üzerinden verdiği oylar.
                    </p>
                </div>
                <div class="info-card rounded-2xl p-6 reveal reveal-delay-2">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="text-3xl">🔄</span>
                        <h3 class="font-cinzel {{ $role === 'mimar' ? 'text-amethyst-100' : 'text-gold-100' }} text-xl font-bold">Swap-Play</h3>
                    </div>
                    <div class="text-4xl font-bold {{ $role === 'mimar' ? 'text-amethyst-200' : 'text-gold-200' }} mb-2">%15</div>
                    <p class="text-parchment-300 text-xs leading-relaxed">
                        Finalistlerin birbirlerinin oyunlarını test ederek verdiği teknik puanlar.
                    </p>
                </div>
            </div>

            {{-- Detaylı Değerlendirme Protokolü --}}
            <div class="max-w-4xl mx-auto {{ $role === 'mimar' ? 'bg-amethyst-400/5 border-amethyst-300/10' : 'bg-gold-400/5 border-gold-300/10' }} border rounded-2xl p-8 reveal">
                <h3 class="font-cinzel {{ $role === 'mimar' ? 'text-amethyst-100' : 'text-gold-100' }} text-lg font-bold mb-6 text-center uppercase tracking-widest">Değerlendirme Protokolü</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-6 text-left">
                    <div>
                        <h4 class="{{ $role === 'mimar' ? 'text-amethyst-200' : 'text-gold-200' }} text-sm font-bold mb-2">Problem & İçgörü (15 Puan)</h4>
                        <p class="text-parchment-300 text-xs leading-relaxed">Çözülen sorunun netliği ve gerçek dünya ihtiyacı.</p>
                    </div>
                    <div>
                        <h4 class="{{ $role === 'mimar' ? 'text-amethyst-200' : 'text-gold-200' }} text-sm font-bold mb-2">Teknik Uygulama (20 Puan)</h4>
                        <p class="text-parchment-300 text-xs leading-relaxed">Kod kalitesi, stabilite ve demonun çalışma durumu.</p>
                    </div>
                    <div>
                        <h4 class="{{ $role === 'mimar' ? 'text-amethyst-200' : 'text-gold-200' }} text-sm font-bold mb-2">Çözüm Tasarımı (15 Puan)</h4>
                        <p class="text-parchment-300 text-xs leading-relaxed">Ürün mantığı ve kullanıcı deneyimi (UX) akışı.</p>
                    </div>
                    <div>
                        <h4 class="{{ $role === 'mimar' ? 'text-amethyst-200' : 'text-gold-200' }} text-sm font-bold mb-2">Yenilik & Farklılık (15 Puan)</h4>
                        <p class="text-parchment-300 text-xs leading-relaxed">Özgünlük ve benzerlerinden ayrışan yaklaşımlar.</p>
                    </div>
                    <div>
                        <h4 class="{{ $role === 'mimar' ? 'text-amethyst-200' : 'text-gold-200' }} text-sm font-bold mb-2">Etki & Ölçek (15 Puan)</h4>
                        <p class="text-parchment-300 text-xs leading-relaxed">Potansiyel değer ve uygulanabilirlik derinliği.</p>
                    </div>
                    <div>
                        <h4 class="{{ $role === 'mimar' ? 'text-amethyst-200' : 'text-gold-200' }} text-sm font-bold mb-2">Sunum Kalitesi (20 Puan)</h4>
                        <p class="text-parchment-300 text-xs leading-relaxed">Fikrin aktarımı ve demo sürecinin profesyonelliği.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Rol Dağılımı --}}
        <div class="mt-48 pt-12">
            <span class="section-voice-label {{ $role === 'mimar' ? 'text-amethyst-300' : 'text-gold-300' }} text-xs font-mono tracking-widest uppercase block mb-2 reveal text-center">Organizasyon Birimleri</span>
            <h2 class="section-title-wraith text-2xl sm:text-3xl font-cinzel font-bold text-parchment-100 mb-8 reveal text-center">
                Rol Dağılımı
            </h2>
            <p class="text-parchment-400 text-sm mb-4 reveal text-center max-w-2xl mx-auto">
                Zıt iki kavramı tek oyunda birleştir. Denge kuran kazanır.
            </p>
            <p class="{{ $role === 'mimar' ? 'text-amethyst-200/70 border-amethyst-300/20 bg-amethyst-400/5' : 'text-gold-200/70 border-gold-300/20 bg-gold-400/5' }} text-[10px] font-mono uppercase tracking-[0.2em] mb-10 reveal text-center max-w-xl mx-auto border py-3 rounded-lg">
                ⚠ Konsey uyarısı: Sistem dengesi için 10 KAŞİF ve 10 MİMAR takımı seçilecektir. Taraf seçerken sistem doluluğunu gözetmeniz önerilir.
            </p>

            {{-- Rol toggle --}}
            <div class="flex items-center justify-center gap-3 mb-10 reveal">
                <a href="?role=kasif" class="role-toggle-btn px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $role === 'kasif' ? 'bg-gold-400 text-parchment-100 border border-gold-300/40' : 'bg-white/5 text-parchment-300 border border-white/10 hover:border-gold-300/30' }}">
                    KAŞİF
                </a>
                <a href="?role=mimar" class="role-toggle-btn px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $role === 'mimar' ? 'bg-parchment-100 text-amethyst-200 border border-amethyst-300/40' : 'bg-white/5 text-parchment-300 border border-white/10 hover:border-parchment-300/40' }}">
                    MİMAR
                </a>
                <span class="text-parchment-400 text-xs ml-2 hidden sm:inline">← birimini seç</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <div class="role-card role-card-adem rounded-2xl p-8 reveal flex flex-col md:flex-row md:items-end gap-6">
                    <div class="role-card-figure flex-shrink-0 w-32 h-40 md:w-36 md:h-44 flex items-end justify-center bg-gold-400/10 rounded-xl overflow-hidden">
                        @php $ademImg = 'images/adem_figure.png'; $ademExists = file_exists(public_path($ademImg)); @endphp
                        @if($ademExists)
                            <img src="{{ asset($ademImg) }}" alt="KAŞİF — Explorer" class="w-full h-full object-contain object-bottom">
                        @else
                            <span class="text-5xl opacity-50 mb-2">⚡</span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-4 mb-5">
                            <div class="w-14 h-14 rounded-2xl bg-gold-400 border border-gold-300/30 flex items-center justify-center text-3xl">🔌</div>
                            <div>
                                <h3 class="font-cinzel text-gold-100 text-2xl font-bold tracking-wide">KAŞİF</h3>
                                <span class="text-gold-300 text-[0.6rem] font-cinzel tracking-[0.25em] uppercase">Explorer</span>
                            </div>
                        </div>
                        <p class="text-parchment-200 text-sm leading-relaxed mb-5">
                            Deneysel, risk alan. Akışı keşfet, inovasyonu kucakla.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1.5 rounded-lg text-[0.65rem] bg-gold-400 text-gold-200 border border-gold-300/20 font-medium">İnovasyon</span>
                            <span class="px-3 py-1.5 rounded-lg text-[0.65rem] bg-gold-400 text-gold-200 border border-gold-300/20 font-medium">Prototipleme</span>
                        </div>
                    </div>
                </div>

                <div class="role-card role-card-baba rounded-2xl p-8 reveal reveal-delay-1 flex flex-col md:flex-row-reverse md:items-end gap-6">
                    <div class="role-card-figure flex-shrink-0 w-32 h-40 md:w-36 md:h-44 flex items-end justify-center bg-dark-700 rounded-xl overflow-hidden">
                        @php $babaImg = 'images/baba_figure.png'; $babaExists = file_exists(public_path($babaImg)); @endphp
                        @if($babaExists)
                            <img src="{{ asset($babaImg) }}" alt="MİMAR — Architect" class="w-full h-full object-contain object-bottom">
                        @else
                            <span class="text-5xl opacity-60 mb-2">🛠️</span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0 text-right md:text-left">
                        <div class="flex items-center justify-end md:justify-start gap-4 mb-5">
                            <div class="md:hidden">
                                <h3 class="font-cinzel text-parchment-100 text-2xl font-bold tracking-wide">MİMAR</h3>
                                <span class="text-parchment-300 text-[0.6rem] font-cinzel tracking-[0.25em] uppercase">Architect</span>
                            </div>
                            <div class="w-14 h-14 rounded-2xl bg-parchment-100 border border-gold-300/40 flex items-center justify-center text-3xl text-gold-200">🛠️</div>
                            <div class="hidden md:block">
                                <h3 class="font-cinzel text-parchment-100 text-2xl font-bold tracking-wide">MİMAR</h3>
                                <span class="text-parchment-300 text-[0.6rem] font-cinzel tracking-[0.25em] uppercase">Architect</span>
                            </div>
                        </div>
                        <p class="text-parchment-200 text-sm leading-relaxed mb-5">
                            Mimari ve bütünlük. Sistemi tutarlı tut, yapıyı sağlam kur.
                        </p>
                        <div class="flex flex-wrap justify-end md:justify-start gap-2">
                            <span class="px-3 py-1.5 rounded-lg text-[0.65rem] bg-parchment-100/60 text-gold-200 border border-gold-300/50 font-medium">Mimari</span>
                            <span class="px-3 py-1.5 rounded-lg text-[0.65rem] bg-parchment-100/60 text-gold-200 border border-gold-300/50 font-medium">Sistem</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="info-card rounded-2xl p-7 text-center reveal border-amethyst-100/20 bg-amethyst-300/5">
                    <span class="section-voice-label text-amethyst-200/80 text-[0.65rem] font-mono tracking-widest uppercase block mb-2">Konsey</span>
                    <div class="text-4xl mb-4">⚖️</div>
                    <h3 class="font-cinzel text-amethyst-100 text-xl font-bold mb-3">KONSEY</h3>
                    <p class="text-parchment-200 text-sm leading-relaxed mt-2">
                        Etkinliğin hakemi. Hücreleri denetler ve puanlama sürecini yönetir.
                    </p>
                </div>

                <div class="info-card rounded-2xl p-7 reveal reveal-delay-1 text-center">
                    <div class="text-4xl mb-4">🃏</div>
                    <h3 class="font-cinzel {{ $role === 'mimar' ? 'text-amethyst-100' : 'text-gold-100' }} text-xl font-bold mb-3">Müdahale Kartları</h3>
                    <p class="text-parchment-300 text-xs">Destek ve stratejik hamleler için kullanılan özel sistem araçları.</p>
                </div>

                <div class="info-card rounded-2xl p-7 reveal reveal-delay-2 text-center">
                    <div class="text-4xl mb-4">🤝</div>
                    <h3 class="font-cinzel {{ $role === 'mimar' ? 'text-amethyst-100' : 'text-gold-100' }} text-xl font-bold mb-3">İletişim Masası</h3>
                    <p class="text-parchment-200 text-sm leading-relaxed">Hücreler arası etkileşim ve stratejik işbirliği alanı.</p>
                </div>
            </div>
        </div>
    </div>
</section>
