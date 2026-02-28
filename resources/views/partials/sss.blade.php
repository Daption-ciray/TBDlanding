{{-- Konsey sesi: kurallar ve sorular --}}
@php $activeRole = $role ?? 'adem'; @endphp
<section
    id="sss"
    class="section-sura py-16 sm:py-24 px-6 relative {{ $activeRole === 'baba' ? 'bg-[#020617] baba-theme' : 'bg-dark-800/50' }}"
>
    <div class="max-w-4xl mx-auto section-sura-content !ml-auto !mr-auto">
        <div class="text-center mb-12">
            <span class="section-voice-label text-amethyst-200/90 text-xs font-mono tracking-widest uppercase block mb-2 reveal">Bilgi Merkezi</span>
            <h2 class="section-title-wraith text-3xl sm:text-4xl font-cinzel font-bold text-parchment-100 mb-4 reveal">
                Sıkça Sorulan Sorular
            </h2>
            <p class="text-parchment-400 text-sm reveal">
                Yeme-içme, uyku, ulaşım ve merak ettiğiniz tüm pratik detaylar.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($faqs ?? [] as $i => $faq)
            @php $num = str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT); @endphp
            <div class="faq-item rounded-xl border border-white/10 bg-white/[0.02] overflow-hidden reveal">
                <div class="faq-question flex items-center gap-4 p-5 cursor-pointer">
                    <span class="text-gold-200/80 font-mono text-xs flex-shrink-0">{{ $num }}</span>
                    <span class="text-parchment-100 text-sm font-medium flex-1 text-left leading-snug">{{ $faq['q'] }}</span>
                    <span class="faq-icon flex-shrink-0 text-parchment-400">
                        <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </span>
                </div>
                <div class="faq-answer px-5 pb-5 pl-14">
                    <p class="text-parchment-300 text-xs leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-12 reveal">
            <a href="mailto:{{ $contact['email'] ?? config('livingcode.contact.email') }}" class="text-gold-200 text-sm hover:underline font-medium">
                Başka bir sorun mu var? Bize yazın →
            </a>
        </div>
    </div>
</section>
