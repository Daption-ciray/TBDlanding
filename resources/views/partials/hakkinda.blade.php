@php $activeRole = $role ?? 'kasif'; @endphp
<section
    id="hakkinda"
    class="section-hucre py-16 sm:py-24 px-6 relative {{ $activeRole === 'mimar' ? 'bg-[#020617] mimar-theme' : 'bg-dark-900 kasif-theme' }}"
>
    <div class="max-w-6xl mx-auto text-center">
        <span class="section-voice-label text-gold-300 text-xs font-mono tracking-widest uppercase block mb-2 reveal">Hakkında</span>
        <h2 class="section-title-wraith text-2xl sm:text-3xl font-cinzel font-bold text-parchment-100 mb-2 reveal">
            Birim Olarak Katıl
        </h2>
        <p class="text-parchment-400 text-sm mb-10 reveal max-w-2xl mx-auto">
            Birimini seç ve başvur. Etkinlik sahasında bir <strong class="{{ $activeRole === 'mimar' ? 'text-amethyst-200' : 'text-gold-200' }}">KAŞİF</strong> takımı ile bir <strong class="{{ $activeRole === 'mimar' ? 'text-amethyst-300' : 'text-gold-300' }}">MİMAR</strong> takımı eşleşerek tek bir **Hücre** protokolünü oluşturur. Tema: bu iki zıt gücü tek sistemde <strong class="{{ $activeRole === 'mimar' ? 'text-amethyst-200' : 'text-gold-200' }}">Kaotik Uyum</strong> ile birleştirmektir.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-14">
            <div class="info-card rounded-3xl p-8 reveal">
                <div class="info-card-icon mb-5">🎮</div>
                <h3 class="font-cinzel {{ $activeRole === 'mimar' ? 'text-amethyst-100' : 'text-gold-100' }} text-xl font-bold mb-2">36 Saat</h3>
                <p class="text-parchment-200 text-sm leading-relaxed mb-4">
                    Yoğun bir oyun geliştirme süreci. Oyununuzun <strong class="{{ $activeRole === 'mimar' ? 'text-amethyst-200' : 'text-gold-200' }}">Kaotik Uyum</strong> temasına uygun olması ana hedeftir.
                </p>
                <div class="flex flex-wrap gap-2 mt-auto justify-center">
                    <span class="px-3 py-1 rounded-full text-[0.65rem] {{ $activeRole === 'mimar' ? 'bg-amethyst-400 text-amethyst-100' : 'bg-gold-400 text-gold-200' }} font-medium">Unity</span>
                    <span class="px-3 py-1 rounded-full text-[0.65rem] {{ $activeRole === 'mimar' ? 'bg-amethyst-400 text-amethyst-100' : 'bg-gold-400 text-gold-200' }} font-medium">Godot</span>
                </div>
            </div>

            <div class="info-card rounded-3xl p-8 reveal reveal-delay-1">
                <div class="info-card-icon mb-5">📜</div>
                <h3 class="font-cinzel {{ $activeRole === 'mimar' ? 'text-amethyst-100' : 'text-gold-100' }} text-xl font-bold mb-2">Konsey Denetimi</h3>
                <p class="text-parchment-200 text-sm leading-relaxed mb-4">
                    Etkinlik boyunca Konsey’in rehberliği, workshop’lar ve profesyonel mentorlarla gelişim fırsatı.
                </p>
            </div>

            <div class="info-card rounded-3xl p-8 reveal reveal-delay-2">
                <div class="info-card-icon mb-5">🏆</div>
                <h3 class="font-cinzel {{ $activeRole === 'mimar' ? 'text-amethyst-100' : 'text-gold-100' }} text-xl font-bold mb-2">Yetenek Keşfi</h3>
                <p class="text-parchment-200 text-sm leading-relaxed mb-4">
                    Sponsor ve mentorlarla etkileşim. Performans gözlemi, takım uyumu.
                </p>
                <p class="text-parchment-300 text-xs">{{ $event['venue'] ?? 'Nişantaşı Üniversitesi' }} · {{ $event['date_display'] ?? '10-11 Nisan 2026' }}</p>
            </div>
        </div>
    </div>
</section>
