{{-- Final CTA + Minimal Sponsor --}}
@php $activeRole = $role ?? 'kasif'; @endphp
<section class="py-16 px-6 text-center border-t border-white/10 {{ $activeRole === 'mimar' ? 'bg-[#020617] mimar-theme' : 'bg-dark-900 kasif-theme' }}">
    <div class="max-w-xl mx-auto reveal">
        <p class="text-parchment-200 mb-2 text-sm italic">
            "Sisteme hoş geldin, Kaşif. Yapıyı koru, Mimar."
        </p>
        <p class="text-parchment-200 mb-2 text-sm">
            Birimini Kaydet.
        </p>
        <p class="text-parchment-400 text-xs mb-6">{{ $event['date_display'] ?? '10-11 Nisan 2026' }} · {{ $event['venue'] ?? 'Nişantaşı Üniversitesi' }}</p>
        <div class="flex flex-col sm:flex-row justify-center gap-3 mb-12">
            <a href="https://docs.google.com/forms/d/1K4EvhIRr2e64HHnLS5evHZBKUiDQwjR1FaAGcZecm4Y/viewform" target="_blank" class="btn-wraith-cta inline-flex items-center justify-center px-10 py-4 rounded-lg text-sm font-semibold text-white {{ $activeRole === 'mimar' ? 'bg-amethyst-300 hover:bg-amethyst-200' : 'bg-gold-200 hover:bg-gold-100' }} transition-all shadow-[0_0_20px_rgba(250,204,21,0.2)]">
                {{ $activeRole === 'mimar' ? 'Mimar Olarak Başvur' : 'Kaşif Olarak Başvur' }}
            </a>
            <a href="#" class="inline-flex items-center justify-center px-8 py-4 rounded-lg text-sm font-medium text-parchment-200 border {{ $activeRole === 'mimar' ? 'border-amethyst-100/30 hover:border-amethyst-100/50 hover:text-amethyst-100' : 'border-gold-300/30 hover:border-gold-300/50 hover:text-gold-300' }} transition-all">
                İzleyici Olarak Başvur
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
