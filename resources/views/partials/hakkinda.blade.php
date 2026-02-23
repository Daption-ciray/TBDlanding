@php $activeRole = $role ?? 'adem'; @endphp
<section
    id="hakkinda"
    class="section-hucre py-16 sm:py-24 px-6 relative {{ $activeRole === 'baba' ? 'bg-[#020617] baba-theme' : 'bg-dark-900' }}"
>
    <div class="max-w-6xl mx-auto">
        <span class="section-voice-label text-gold-300 text-xs font-mono tracking-widest uppercase block mb-2 reveal">Hakkında</span>
        <h2 class="section-title-wraith text-2xl sm:text-3xl font-cinzel font-bold text-parchment-100 mb-2 reveal">
            Takım Olarak Katıl
        </h2>
        <p class="text-parchment-400 text-sm mb-10 reveal">
            Takımla başvur; <span class="term-tooltip" data-term="Takımların etkinlikteki kimliği">Hücre</span> kimliği al. Her Hücrede <strong class="text-gold-200">ADEM</strong> (Kaşif) ve <strong class="text-gold-300">BABA</strong> (Mimar) birlikte çalışır. Tema: zıt iki kavramı tek oyunda <strong class="text-gold-200">Kaotik Uyum</strong> ile birleştirmek.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-14">
            <div class="info-card rounded-3xl p-8 reveal">
                <div class="info-card-icon mb-5">🎮</div>
                <h3 class="font-cinzel text-gold-100 text-xl font-bold mb-2">36 Saat</h3>
                <p class="text-parchment-200 text-sm leading-relaxed mb-4">
                    Yoğun game jam. Unity, Unreal, Godot serbest. Tek kural: <strong class="text-gold-200">Kaotik Uyum</strong> temasına uygun oyun.
                </p>
                <div class="flex flex-wrap gap-2 mt-auto">
                    <span class="px-3 py-1 rounded-full text-[0.65rem] bg-gold-400 text-gold-200 font-medium">Unity</span>
                    <span class="px-3 py-1 rounded-full text-[0.65rem] bg-gold-400 text-gold-200 font-medium">Godot</span>
                </div>
            </div>

            <div class="info-card rounded-3xl p-8 reveal reveal-delay-1">
                <div class="info-card-icon mb-5">📜</div>
                <h3 class="font-cinzel text-gold-100 text-xl font-bold mb-2">Canlı Etkinlikler</h3>
                <p class="text-parchment-200 text-sm leading-relaxed mb-4">
                    Mühürlü zarflar, müdahale kartları, diplomasi masası. Sunumlar, workshop’lar, networking.
                </p>
            </div>

            <div class="info-card rounded-3xl p-8 reveal reveal-delay-2">
                <div class="info-card-icon mb-5">🏆</div>
                <h3 class="font-cinzel text-gold-100 text-xl font-bold mb-2">Yetenek Keşfi</h3>
                <p class="text-parchment-200 text-sm leading-relaxed mb-4">
                    Sponsor ve mentorlarla etkileşim. Performans gözlemi, takım uyumu.
                </p>
                <p class="text-parchment-300 text-xs">{{ $event['venue'] ?? 'Nişantaşı Üniversitesi' }} · {{ $event['date_display'] ?? '3-4 Nisan 2026' }}</p>
            </div>
        </div>
    </div>
</section>
