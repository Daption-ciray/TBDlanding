@extends('layouts.app')

@section('content')
<section class="min-h-[70vh] flex flex-col items-center justify-center px-6 py-20 bg-dark-900">
    <div class="text-center max-w-md mx-auto">
        <span class="section-voice-label text-gold-300 text-xs font-mono tracking-widest uppercase block mb-4">Yakında</span>
        <h1 class="font-cinzel text-4xl sm:text-5xl font-bold text-parchment-100 mb-4">
            @if(($section ?? '') === 'viewer')
                İzleyici
            @else
                Arena
            @endif
        </h1>
        <p class="text-parchment-300 text-lg font-cinzel mb-8">Coming Soon</p>
        <p class="text-parchment-400 text-sm mb-10">
            @if(($section ?? '') === 'viewer')
                Evreni izle, XP kazan, rozet topla. Bu bölüm yakında açılacak.
            @else
                Sıralama, görevler, kartlar ve canlı akış. Bu bölüm yakında açılacak.
            @endif
        </p>
        <a href="{{ url('/') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-lg text-sm font-medium text-parchment-200 border border-gold-300/30 hover:border-gold-200/50 hover:text-gold-200 transition-colors">
            ← Ana sayfaya dön
        </a>
    </div>
</section>
@endsection
