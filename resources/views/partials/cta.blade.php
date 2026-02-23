{{-- Final CTA + Minimal Sponsor --}}
<section class="py-16 px-6 text-center border-t border-white/10 bg-dark-900">
    <div class="max-w-xl mx-auto reveal">
        <p class="text-parchment-200 mb-2 text-sm">
            <span class="text-gold-200 font-medium">Takımınla</span> başvur,
            <span class="text-amethyst-100 font-medium">Şura</span>'ya sun.
        </p>
        <p class="text-parchment-400 text-xs mb-6">{{ $event['date_display'] ?? '3-4 Nisan 2026' }} · {{ $event['venue'] ?? 'Nişantaşı Üniversitesi' }}</p>
        <div class="flex flex-col sm:flex-row justify-center gap-3 mb-12">
            <a href="#" class="btn-wraith-cta inline-flex items-center justify-center px-10 py-4 rounded-lg text-sm font-semibold text-black bg-gold-200 hover:bg-gold-100 transition-all">
                Takımla Başvur
            </a>
            <a href="{{ route('viewer') }}" class="inline-flex items-center justify-center px-8 py-4 rounded-lg text-sm font-medium text-parchment-200 border border-amethyst-100/30 hover:border-amethyst-100/50 hover:text-amethyst-100 transition-all">
                İzleyici Olarak Katıl
            </a>
        </div>
    </div>

    {{-- Minimal sponsor logoları --}}
    @if(!empty($sponsorTiers ?? []))
    <div class="max-w-3xl mx-auto reveal">
        <p class="text-parchment-400 text-xs uppercase tracking-widest mb-6">Sponsorlar</p>
        <div class="flex flex-wrap items-center justify-center gap-8">
            @foreach ($sponsorTiers ?? [] as $key => $tier)
            <div class="text-center opacity-60 hover:opacity-100 transition-opacity">
                <span class="text-2xl block mb-1">{{ $tier['icon'] }}</span>
                <span class="text-parchment-300 text-[0.65rem]">{{ $tier['name'] }}</span>
            </div>
            @endforeach
        </div>
        <p class="text-parchment-400 text-xs mt-6">
            Sponsor olmak için:
            <a href="mailto:{{ $contact['email'] ?? config('livingcode.contact.email') }}" class="text-gold-200 hover:underline">
                {{ $contact['email'] ?? config('livingcode.contact.email') }}
            </a>
        </p>
    </div>
    @endif
</section>
