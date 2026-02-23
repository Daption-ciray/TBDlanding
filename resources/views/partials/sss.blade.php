{{-- Şura sesi: kurallar ve sorular --}}
<section id="sss" class="section-sura py-16 sm:py-24 px-6 relative bg-dark-800/50">
    <div class="max-w-3xl mx-auto section-sura-content">
        <span class="section-voice-label text-amethyst-200/90 text-xs font-mono tracking-widest uppercase block mb-2 reveal">Şura</span>
        <h2 class="section-title-wraith text-2xl sm:text-3xl font-cinzel font-bold text-parchment-100 mb-2 reveal">
            Sıkça Sorulan Sorular
        </h2>
        <p class="text-parchment-400 text-sm mb-6 reveal">
            Evrene dair sorular — <span class="term-tooltip text-amethyst-100" data-term="Etkinliğin merkezi jüri konseyi">Şura</span>'nın çerçevesi. Aşağıdaki sorular etkinlik, katılım koşulları, gamification sistemi ve değerlendirme kriterleri hakkında bilgi verir.
        </p>
        <p class="text-parchment-300 text-xs mb-10 reveal">
            Sorularınız mı var? <a href="mailto:{{ $contact['email'] ?? config('livingcode.contact.email') }}" class="text-gold-200 hover:underline">Bize yazın</a> — Şura size yardımcı olacaktır.
        </p>

        <div class="space-y-2">
            @foreach ($faqs ?? [] as $i => $faq)
            @php $num = str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT); @endphp
            <div class="faq-item rounded-lg border border-white/10 bg-white/[0.02] overflow-hidden reveal">
                <div class="faq-question flex items-center gap-4 p-4 sm:p-5 cursor-pointer">
                    <span class="text-gold-200/80 font-mono text-sm flex-shrink-0">{{ $num }}</span>
                    <span class="text-parchment-100 text-sm font-medium flex-1 text-left">{{ $faq['q'] }}</span>
                    <span class="faq-icon flex-shrink-0 text-parchment-400">
                        <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </span>
                </div>
                <div class="faq-answer px-5 pb-5 pl-14 sm:pl-[4.5rem]">
                    <p class="text-parchment-200 text-sm leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-10 reveal">
            <a href="mailto:{{ $contact['email'] ?? config('livingcode.contact.email') }}" class="text-gold-200 text-sm hover:underline font-medium">
                Bize yazın →
            </a>
        </div>
    </div>
</section>
