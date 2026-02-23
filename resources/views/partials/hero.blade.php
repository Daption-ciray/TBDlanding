@php
    $activeRole = $role ?? 'adem';
@endphp
<section
    id="hero"
    class="hero-wraith min-h-[90vh] flex flex-col justify-center relative overflow-hidden {{ $activeRole === 'baba' ? 'hero-theme-baba' : 'hero-theme-adem' }}"
    data-countdown="{{ $countdownTarget ?? config('livingcode.countdown_target') }}"
>
    <div class="hero-wraith-bg"></div>

    <div class="relative z-10 px-6 py-20 max-w-4xl mx-auto text-center">
        <p class="code-tagline font-mono text-lg sm:text-xl md:text-2xl mb-8 reveal {{ $activeRole === 'baba' ? 'text-amethyst-200' : 'text-gold-200' }}">
            <code class="font-mono">&lt;Evrene gir /&gt;</code>
        </p>

        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-cinzel font-bold text-parchment-100 mb-6 reveal tracking-tight">
            THE LIVING CODE
        </h1>
        <p class="text-parchment-300 text-sm sm:text-base mb-2 reveal">{{ $event['date_display'] ?? '3-4 Nisan 2026' }} · {{ $event['venue'] ?? 'Nişantaşı Üniversitesi' }}, {{ $event['venue_city'] ?? 'İstanbul' }}</p>

        <div class="flex flex-wrap justify-center gap-4 sm:gap-6 my-8 reveal">
            @foreach (array_slice($stats ?? [], 0, 3) as $stat)
            <div class="stat-pill rounded-lg px-5 py-3 border border-white/10 bg-white/5">
                <span class="font-cinzel font-bold text-xl {{ $activeRole === 'baba' ? 'text-amethyst-200' : 'text-gold-200' }}">{{ $stat['value'] }}{{ $stat['suffix'] ?? '' }}</span>
                <span class="text-parchment-300 text-xs block mt-0.5 uppercase tracking-wider">{{ $stat['label'] }}</span>
            </div>
            @endforeach
        </div>

        <p class="text-parchment-200 text-base max-w-xl mx-auto mb-10 reveal">
            36 saatlik game jam. Takımla başvur,
            <span class="term-tooltip {{ $activeRole === 'baba' ? 'text-amethyst-200' : 'text-gold-200' }}" data-term="Takımların etkinlikteki kimliği">Hücre</span>
            ol,
            <span class="term-tooltip {{ $activeRole === 'baba' ? 'text-amethyst-300' : 'text-gold-300' }}" data-term="Etkinliğin jüri konseyi">Şura</span>
            dört fazda yol göstersin. Tema:
            <strong class="{{ $activeRole === 'baba' ? 'text-amethyst-200' : 'text-gold-200' }}">Kaotik Uyum</strong>.
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-4 reveal">
            <a href="#" class="btn-wraith-cta inline-flex items-center justify-center px-8 py-4 rounded-lg text-sm font-semibold text-black {{ $activeRole === 'baba' ? 'bg-amethyst-300 hover:bg-amethyst-200' : 'bg-gold-200 hover:bg-gold-100' }} transition-all">
                Takımımla Başvur
            </a>
            <a href="{{ url('/arena') }}" class="btn-wraith-ghost inline-flex items-center justify-center px-8 py-4 rounded-lg text-sm font-medium {{ $activeRole === 'baba' ? 'text-slate-100 border-slate-500 hover:border-amethyst-200/60 hover:text-amethyst-200' : 'text-parchment-200 border-white/20 hover:border-gold-200/50 hover:text-gold-200' }} transition-all">
                Arena'ya Git →
            </a>
        </div>

        <div class="flex justify-center gap-2 sm:gap-4 mt-10 reveal">
            <div class="countdown-compact rounded-lg px-3 py-2 min-w-[56px] text-center bg-white/5 border border-white/10">
                <span class="countdown-value font-mono text-lg font-bold {{ $activeRole === 'baba' ? 'text-amethyst-200' : 'text-gold-200' }}" id="countdown-days">--</span>
                <span class="text-parchment-300 text-[0.6rem] block uppercase">Gün</span>
            </div>
            <div class="countdown-compact rounded-lg px-3 py-2 min-w-[56px] text-center bg-white/5 border border-white/10">
                <span class="countdown-value font-mono text-lg font-bold {{ $activeRole === 'baba' ? 'text-amethyst-200' : 'text-gold-200' }}" id="countdown-hours">--</span>
                <span class="text-parchment-300 text-[0.6rem] block uppercase">Saat</span>
            </div>
            <div class="countdown-compact rounded-lg px-3 py-2 min-w-[56px] text-center bg-white/5 border border-white/10">
                <span class="countdown-value font-mono text-lg font-bold {{ $activeRole === 'baba' ? 'text-amethyst-200' : 'text-gold-200' }}" id="countdown-minutes">--</span>
                <span class="text-parchment-300 text-[0.6rem] block uppercase">Dk</span>
            </div>
            <div class="countdown-compact rounded-lg px-3 py-2 min-w-[56px] text-center bg-white/5 border border-white/10">
                <span class="countdown-value font-mono text-lg font-bold {{ $activeRole === 'baba' ? 'text-amethyst-200' : 'text-gold-200' }}" id="countdown-seconds">--</span>
                <span class="text-parchment-300 text-[0.6rem] block uppercase">Sn</span>
            </div>
        </div>
    </div>
</section>
