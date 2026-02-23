@php $role = $role ?? 'adem'; @endphp
<section id="konsept" class="section-hucre py-16 sm:py-24 px-6 relative bg-dark-800/50">
    <div class="max-w-6xl mx-auto">
        <span class="section-voice-label text-gold-300 text-xs font-mono tracking-widest uppercase block mb-2 reveal">Konsept</span>
        <h2 class="section-title-wraith text-2xl sm:text-3xl font-cinzel font-bold text-parchment-100 mb-2 reveal">
            Kaotik Uyum
        </h2>
        <p class="text-parchment-400 text-sm mb-6 reveal">
            Evrenin ana teması <strong class="text-gold-200">Kaotik Uyum</strong>. Birbirine zıt iki kavramı (tür, mekanik, estetik ya da anlatı düzeyinde) aynı çekirdek oynanışta bir arada tutmak zorundasın. Çelişkiyi dengeleyen kazanır; kopuşu yaratan Şura tarafından cezalandırılır.
        </p>

        {{-- Rol toggle --}}
        <div class="flex items-center justify-center gap-3 mb-10 reveal">
            <a href="?role=adem" class="role-toggle-btn px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $role === 'adem' ? 'bg-gold-400 text-gold-200 border border-gold-300/40' : 'bg-white/5 text-parchment-300 border border-white/10 hover:border-gold-300/30' }}">
                🔥 ADEM
            </a>
            <a href="?role=baba" class="role-toggle-btn px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $role === 'baba' ? 'bg-amethyst-300/30 text-amethyst-100 border border-amethyst-100/40' : 'bg-white/5 text-parchment-300 border border-white/10 hover:border-amethyst-100/30' }}">
                🛡️ BABA
            </a>
            <span class="text-parchment-400 text-xs ml-2 hidden sm:inline">← tarafını seç</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div class="role-card role-card-adem rounded-2xl p-8 reveal">
                <div class="flex items-center gap-4 mb-5">
                    <div class="w-14 h-14 rounded-2xl bg-gold-400 border border-gold-300/30 flex items-center justify-center text-3xl">🔥</div>
                    <div>
                        <h3 class="font-cinzel text-gold-100 text-2xl font-bold tracking-wide">ADEM</h3>
                        <span class="text-gold-300 text-xs font-cinzel tracking-[0.25em]">KAŞİF</span>
                    </div>
                </div>
                <p class="text-parchment-200 leading-relaxed mb-5">
                    <strong class="text-gold-200">Deneysel ve risk alan rol.</strong> Kaşif ruhuyla sınırları zorlar, hızlı prototipleme ile vizyonu ayağa kaldırır. İnovasyonu kucaklar, başarısızlıktan öğrenir. Oynanışı öne çıkarır, deneysel mekaniklerle oyuncu deneyimini keşfeder. ADEM, "çalışır mı?" sorusunu hızlıca test eder ve iterasyon yapar.
                </p>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1.5 rounded-lg text-xs bg-gold-400 text-gold-200 border border-gold-300/20 font-medium">İnovasyon</span>
                    <span class="px-3 py-1.5 rounded-lg text-xs bg-gold-400 text-gold-200 border border-gold-300/20 font-medium">Risk Alma</span>
                    <span class="px-3 py-1.5 rounded-lg text-xs bg-gold-400 text-gold-200 border border-gold-300/20 font-medium">Prototipleme</span>
                </div>
            </div>

            <div class="role-card role-card-baba rounded-2xl p-8 reveal reveal-delay-1">
                <div class="flex items-center gap-4 mb-5">
                    <div class="w-14 h-14 rounded-2xl bg-amethyst-300 border border-amethyst-100/30 flex items-center justify-center text-3xl">🛡️</div>
                    <div>
                        <h3 class="font-cinzel text-amethyst-100 text-2xl font-bold tracking-wide">BABA</h3>
                        <span class="text-amethyst-200 text-xs font-cinzel tracking-[0.25em]">MİMAR</span>
                    </div>
                </div>
                <p class="text-parchment-200 leading-relaxed mb-5">
                    <strong class="text-amethyst-100">Yapısal bütünlük ve sistem tutarlılığı odaklı.</strong> Mimari kararları yönetir, teknik borçtan kaçınır, sürdürülebilir temeller inşa eder. Sistemin uzun vadede nasıl çalışacağını düşünür, kod kalitesini korur. BABA, "nasıl ölçeklenir?" ve "nasıl sürdürülebilir kalır?" sorularına cevap arar.
                </p>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1.5 rounded-lg text-xs bg-amethyst-300 text-amethyst-100 border border-amethyst-100/20 font-medium">Mimari</span>
                    <span class="px-3 py-1.5 rounded-lg text-xs bg-amethyst-300 text-amethyst-100 border border-amethyst-100/20 font-medium">Bütünlük</span>
                    <span class="px-3 py-1.5 rounded-lg text-xs bg-amethyst-300 text-amethyst-100 border border-amethyst-100/20 font-medium">Strateji</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="info-card rounded-2xl p-7 text-center reveal border-amethyst-100/20 bg-amethyst-300/5">
                <span class="section-voice-label text-amethyst-200/80 text-[0.65rem] font-mono tracking-widest uppercase block mb-2">Konsey</span>
                <div class="text-4xl mb-4">⚖️</div>
                <h3 class="font-cinzel text-amethyst-100 text-xl font-bold mb-3">ŞURA</h3>
                <p class="text-parchment-200 text-sm leading-relaxed mt-2">
                    Evrenin merkezi otoritesi ve hakemi. Tarafsız görünür; fakat sistemin dengesini korumak adına aktif müdahalede bulunur. Hücreleri denetler, <span class="term-tooltip" data-term="Lütuf (destek) ve Gazap (sabotaj) kartları">müdahale kartları</span> dağıtır, kuralları büker. Şura'nın kararları final değerlendirmesini etkiler.
                </p>
            </div>

            <div class="info-card rounded-2xl p-7 reveal reveal-delay-1">
                <div class="text-4xl mb-4">🃏</div>
                <h3 class="font-cinzel text-gold-100 text-xl font-bold mb-3">Müdahale Kartları</h3>
                <p class="text-parchment-300 text-xs mb-3">İmtihan fazında aktifleşir. Kredi ile Şura Pazarı'ndan satın alınır.</p>
                <div class="space-y-3 mt-4">
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-gold-400/50 border border-gold-300/15">
                        <span class="text-lg">✨</span>
                        <div>
                            <span class="text-gold-200 text-sm font-medium">Lütuf Kartları</span>
                            <p class="text-parchment-300 text-xs">Mentor desteği, XP boost, kredi yağmuru, kalkan koruması, Şura lütfu</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-red-500/5 border border-red-500/15">
                        <span class="text-lg">⚡</span>
                        <div>
                            <span class="text-red-400 text-sm font-medium">Gazap Kartları</span>
                            <p class="text-parchment-300 text-xs">Zaman hırsızı, kod karıştırıcı, kredi vergisi, rol karıştırıcı, Şura gazabı</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="info-card rounded-2xl p-7 reveal reveal-delay-2">
                <div class="text-4xl mb-4">🤝</div>
                <h3 class="font-cinzel text-gold-100 text-xl font-bold mb-3">Diplomasi Masası</h3>
                <p class="text-parchment-200 text-sm leading-relaxed mb-4">
                    İmtihan fazında aktifleşir. Hücreler arası stratejik kararlar alınır. Oyun teorisi mekaniği: <strong class="text-gold-200">Mahkûm İkilemi</strong>.
                </p>
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between items-center p-2 rounded-lg bg-green-500/5 border border-green-500/15">
                        <span class="text-green-400 font-medium">Çift Destek</span>
                        <span class="text-parchment-300">→ Her iki Hücre bütünlük bonusu alır</span>
                    </div>
                    <div class="flex justify-between items-center p-2 rounded-lg bg-red-500/5 border border-red-500/15">
                        <span class="text-red-400 font-medium">İhanet</span>
                        <span class="text-parchment-300">→ Sabotajcı kredi kazanır, mağdur ceza alır</span>
                    </div>
                    <div class="flex justify-between items-center p-2 rounded-lg bg-orange-500/5 border border-orange-500/15">
                        <span class="text-orange-400 font-medium">Çift Sabotaj</span>
                        <span class="text-parchment-300">→ Her iki Hücre oynanabilirlik cezası alır</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
