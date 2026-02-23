@php
$tierClasses = [
    'diamond' => 'diamond',
    'gold' => 'gold-tier',
    'silver' => 'silver',
    'supporter' => 'supporter',
];
$bulletClasses = [
    'diamond' => 'text-cyan-400',
    'gold' => 'text-gold-200',
    'silver' => 'text-gray-400',
    'supporter' => 'text-amethyst-100',
];
$titleClasses = [
    'diamond' => 'text-cyan-300',
    'gold' => 'text-gold-100',
    'silver' => 'text-gray-300',
    'supporter' => 'text-amethyst-100',
];
$priceClasses = [
    'diamond' => 'text-cyan-200',
    'gold' => 'text-gold-200',
    'silver' => 'text-gray-300',
    'supporter' => 'text-amethyst-100',
];
@endphp
<section id="sponsorluk" class="py-16 sm:py-24 px-6 relative bg-dark-900">
    <div class="max-w-6xl mx-auto">
        <h2 class="section-title-wraith text-2xl sm:text-3xl font-cinzel font-bold text-parchment-100 mb-2 reveal">
            Sponsorluk Paketleri
        </h2>
        <p class="text-parchment-400 text-sm mb-12 reveal">Kaosun içindeki düzeni birlikte inşa edelim.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ($sponsorTiers ?? [] as $key => $tier)
            <div class="sponsor-card {{ $tierClasses[$key] ?? $key }} rounded-2xl p-6 reveal {{ $loop->index > 0 ? 'reveal-delay-' . $loop->index : '' }}">
                <div class="text-center mb-4">
                    <span class="text-3xl">{{ $tier['icon'] }}</span>
                    <h3 class="font-cinzel {{ $titleClasses[$key] ?? 'text-gold-100' }} text-base font-bold mt-2">{{ $tier['name'] }}</h3>
                    <p class="text-parchment-300 text-[0.65rem]">{{ $tier['subtitle'] ?: '&nbsp;' }}</p>
                    <div class="sponsor-price text-2xl {{ $priceClasses[$key] ?? 'text-gold-200' }} mt-2">{{ $tier['price'] }}</div>
                </div>
                <ul class="text-parchment-200 text-xs space-y-2.5">
                    @foreach ($tier['features'] as $feature)
                    <li class="flex items-start gap-2"><span class="{{ $bulletClasses[$key] ?? 'text-gold-200' }}">✦</span>{{ $feature }}</li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-12 reveal">
            <a href="mailto:{{ $contact['email'] ?? config('livingcode.contact.email') }}" class="btn-gold px-8 py-3.5 rounded-xl text-sm inline-block">
                📩 Sponsor Olun
            </a>
            <p class="text-parchment-300 text-xs mt-3">
                İletişim: <a href="mailto:{{ $contact['email'] ?? config('livingcode.contact.email') }}" class="text-gold-200 hover:underline">{{ $contact['email'] ?? config('livingcode.contact.email') }}</a>
            </p>
        </div>
    </div>
</section>
