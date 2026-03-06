@php
    $activeRole = $role ?? 'kasif';
@endphp
<section
    id="hero"
    class="hero-wraith min-h-[90vh] flex flex-col justify-center relative overflow-hidden {{ $activeRole === 'mimar' ? 'hero-theme-baba' : 'hero-theme-adem' }}"
    data-countdown="{{ $countdownTarget ?? config('livingcode.countdown_target') }}"
>
    <div class="hero-wraith-bg"></div>

    <div class="relative z-10 px-6 py-20 max-w-4xl mx-auto text-center">
        <p class="code-tagline font-mono text-lg sm:text-xl md:text-2xl mb-8 reveal {{ $activeRole === 'mimar' ? 'text-amethyst-200' : 'text-gold-200' }}">
            <code class="font-mono">&lt;Evrene gir /&gt;</code>
        </p>

        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-cinzel font-bold text-parchment-100 mb-6 reveal tracking-tight">
            THE LIVING CODE
        </h1>
        <p class="text-parchment-300 text-sm sm:text-base mb-2 reveal">{{ $event['date_display'] ?? '3-4 Nisan 2026' }} · {{ $event['venue'] ?? 'Nişantaşı Üniversitesi' }}, {{ $event['venue_city'] ?? 'İstanbul' }}</p>

        @if(isset($statusText))
        <div class="mb-4 reveal flex flex-col items-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 mb-2">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $activeRole === 'mimar' ? 'bg-amethyst-400' : 'bg-gold-400' }} opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 {{ $activeRole === 'mimar' ? 'bg-amethyst-300' : 'bg-gold-200' }}"></span>
                </span>
                <span class="font-mono text-[10px] uppercase tracking-widest text-parchment-200">
                    Birim Durumu: <span class="{{ $activeRole === 'mimar' ? 'text-amethyst-200' : 'text-gold-200' }}">{{ $statusText }}</span>
                </span>
            </div>
            
            <div class="w-48 h-1 bg-white/5 rounded-full overflow-hidden border border-white/5">
                <div class="h-full {{ $activeRole === 'mimar' ? 'bg-amethyst-300' : 'bg-gold-200' }} transition-all duration-1000 ease-out shadow-[0_0_10px_rgba(250,204,21,0.5)]" style="width: {{ $syncPercent ?? 0 }}%"></div>
            </div>
            <span class="font-mono text-[9px] text-parchment-400 mt-1 uppercase tracking-tighter">Senkronizasyon: %{{ $syncPercent ?? 0 }}</span>
        </div>
        @endif

        <div class="flex flex-wrap justify-center gap-4 sm:gap-6 my-8 reveal">
            @foreach (array_slice($stats ?? [], 0, 3) as $stat)
            <div class="stat-pill rounded-lg px-5 py-3 border border-white/10 bg-white/5">
                <span class="font-cinzel font-bold text-xl {{ $activeRole === 'mimar' ? 'text-amethyst-200' : 'text-gold-200' }}">{{ $stat['value'] }}{{ $stat['suffix'] ?? '' }}</span>
                <span class="text-parchment-300 text-xs block mt-0.5 uppercase tracking-wider">{{ $stat['label'] }}</span>
            </div>
            @endforeach
        </div>

        <p class="text-parchment-200 text-base max-w-xl mx-auto mb-10 reveal">
            36 saatlik game jam. Takımla başvur,
            <span class="term-tooltip {{ $activeRole === 'mimar' ? 'text-amethyst-200' : 'text-gold-200' }}" data-term="Takımların etkinlikteki kimliği">Hücre</span>
            ol,
            <span class="term-tooltip {{ $activeRole === 'mimar' ? 'text-amethyst-300' : 'text-gold-300' }}" data-term="Etkinliğin jüri konseyi">Konsey</span>
            dört fazda yol göstersin. Tema:
            <strong class="{{ $activeRole === 'mimar' ? 'text-amethyst-200' : 'text-gold-200' }}">Kaotik Uyum</strong>.
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-4 reveal">
            <a href="https://docs.google.com/forms/d/1K4EvhIRr2e64HHnLS5evHZBKUiDQwjR1FaAGcZecm4Y/viewform" target="_blank" class="btn-wraith-cta inline-flex items-center justify-center px-10 py-4 rounded-lg text-sm font-semibold text-white {{ $activeRole === 'mimar' ? 'bg-amethyst-300 hover:bg-amethyst-200' : 'bg-gold-200 hover:bg-gold-100' }} transition-all shadow-[0_0_20px_rgba(250,204,21,0.2)]">
                Takımla Başvur
            </a>
            <a href="#" class="inline-flex items-center justify-center px-6 py-2.5 rounded-lg text-xs font-medium text-parchment-200 border {{ $activeRole === 'mimar' ? 'border-amethyst-100/30 hover:border-amethyst-100/50 hover:text-amethyst-100' : 'border-gold-300/30 hover:border-gold-300/50 hover:text-gold-300' }} transition-all">
                İzleyici Olarak Başvur
            </a>
        </div>

        <div class="flex justify-center gap-2 sm:gap-4 mt-10 reveal">
            <div class="countdown-compact rounded-lg px-3 py-2 min-w-[56px] text-center bg-white/5 border border-white/10">
                <span class="countdown-value font-mono text-lg font-bold {{ $activeRole === 'mimar' ? 'text-amethyst-200' : 'text-gold-200' }}" id="countdown-days">--</span>
                <span class="text-parchment-300 text-[0.6rem] block uppercase">Gün</span>
            </div>
            <div class="countdown-compact rounded-lg px-3 py-2 min-w-[56px] text-center bg-white/5 border border-white/10">
                <span class="countdown-value font-mono text-lg font-bold {{ $activeRole === 'mimar' ? 'text-amethyst-200' : 'text-gold-200' }}" id="countdown-hours">--</span>
                <span class="text-parchment-300 text-[0.6rem] block uppercase">Saat</span>
            </div>
            <div class="countdown-compact rounded-lg px-3 py-2 min-w-[56px] text-center bg-white/5 border border-white/10">
                <span class="countdown-value font-mono text-lg font-bold {{ $activeRole === 'mimar' ? 'text-amethyst-200' : 'text-gold-200' }}" id="countdown-minutes">--</span>
                <span class="text-parchment-300 text-[0.6rem] block uppercase">Dk</span>
            </div>
            <div class="countdown-compact rounded-lg px-3 py-2 min-w-[56px] text-center bg-white/5 border border-white/10">
                <span class="countdown-value font-mono text-lg font-bold {{ $activeRole === 'mimar' ? 'text-amethyst-200' : 'text-gold-200' }}" id="countdown-seconds">--</span>
                <span class="text-parchment-300 text-[0.6rem] block uppercase">Sn</span>
            </div>
        </div>
    </div>
</section>
