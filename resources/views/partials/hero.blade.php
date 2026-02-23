<section id="hero" class="hero-wraith min-h-[90vh] flex flex-col justify-center relative overflow-hidden" data-countdown="{{ $countdownTarget ?? config('livingcode.countdown_target') }}">
    <div class="hero-wraith-bg"></div>

    <div class="relative z-10 px-6 py-20 max-w-4xl mx-auto text-center">
        <p class="code-tagline font-mono text-lg sm:text-xl md:text-2xl mb-8 reveal text-gold-200">
            <code class="font-mono">&lt;Evrene gir /&gt;</code>
        </p>

        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-cinzel font-bold text-parchment-100 mb-6 reveal tracking-tight">
            THE LIVING CODE
        </h1>
        <p class="text-parchment-300 text-sm sm:text-base mb-2 reveal">{{ $event['date_display'] ?? '3-4 Nisan 2026' }} · {{ $event['venue'] ?? 'Nişantaşı Üniversitesi' }}, {{ $event['venue_city'] ?? 'İstanbul' }}</p>

        <div class="flex flex-wrap justify-center gap-4 sm:gap-6 my-8 reveal">
            @foreach (array_slice($stats ?? [], 0, 3) as $stat)
            <div class="stat-pill rounded-lg px-5 py-3 border border-white/10 bg-white/5">
                <span class="font-cinzel font-bold text-xl text-gold-200">{{ $stat['value'] }}{{ $stat['suffix'] ?? '' }}</span>
                <span class="text-parchment-300 text-xs block mt-0.5 uppercase tracking-wider">{{ $stat['label'] }}</span>
            </div>
            @endforeach
        </div>

        <p class="text-parchment-200 text-base sm:text-lg leading-relaxed max-w-2xl mx-auto mb-6 reveal">
            <strong class="text-gold-200">36 saatlik kaotik oyun geliştirme deneyimi.</strong> Klasik bir game jam değil — asimetrik işbirliği, kontrollü kaos ve canlı bir evren üzerine kurulmuş benzersiz bir sistem tasarımı deneyi.
        </p>
        <p class="text-parchment-300 text-sm sm:text-base leading-relaxed max-w-2xl mx-auto mb-10 reveal">
            Takımınla başvur, <span class="term-tooltip text-gold-200" data-term="Takımların etkinlikteki kimliği — her Hücre ADEM ve BABA rolleriyle asimetrik işbirliği yapar">Hücre</span> kimliği kazan. <span class="term-tooltip text-amethyst-100" data-term="Etkinliğin merkezi jüri konseyi — süreci izler, müdahale eder, kuralları büker">Şura</span>'nın <span class="term-tooltip" data-term="Etkinliğin 4 ana fazı: Genesis (başlangıç), Vahiy (ortak dil), İmtihan (diplomasi), Kıyamet (final)">dört farzında</span> yol al. Birbirine zıt iki kavramı tek bir oyunda dengeli şekilde birleştiren kazanır.
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-4 reveal">
            <a href="#" class="btn-wraith-cta inline-flex items-center justify-center px-8 py-4 rounded-lg text-sm font-semibold text-black bg-gold-200 hover:bg-gold-100 transition-all">
                Takımımla Başvur
            </a>
            <a href="{{ route('arena') }}" class="btn-wraith-ghost inline-flex items-center justify-center px-8 py-4 rounded-lg text-sm font-medium text-parchment-200 border border-white/20 hover:border-gold-200/50 hover:text-gold-200 transition-all">
                Arena'ya Git →
            </a>
        </div>

        <div class="flex justify-center gap-2 sm:gap-4 mt-10 reveal">
            <div class="countdown-compact rounded-lg px-3 py-2 min-w-[56px] text-center bg-white/5 border border-white/10">
                <span class="countdown-value font-mono text-lg font-bold text-gold-200" id="countdown-days">--</span>
                <span class="text-parchment-300 text-[0.6rem] block uppercase">Gün</span>
            </div>
            <div class="countdown-compact rounded-lg px-3 py-2 min-w-[56px] text-center bg-white/5 border border-white/10">
                <span class="countdown-value font-mono text-lg font-bold text-gold-200" id="countdown-hours">--</span>
                <span class="text-parchment-300 text-[0.6rem] block uppercase">Saat</span>
            </div>
            <div class="countdown-compact rounded-lg px-3 py-2 min-w-[56px] text-center bg-white/5 border border-white/10">
                <span class="countdown-value font-mono text-lg font-bold text-gold-200" id="countdown-minutes">--</span>
                <span class="text-parchment-300 text-[0.6rem] block uppercase">Dk</span>
            </div>
            <div class="countdown-compact rounded-lg px-3 py-2 min-w-[56px] text-center bg-white/5 border border-white/10">
                <span class="countdown-value font-mono text-lg font-bold text-gold-200" id="countdown-seconds">--</span>
                <span class="text-parchment-300 text-[0.6rem] block uppercase">Sn</span>
            </div>
        </div>
    </div>
</section>
