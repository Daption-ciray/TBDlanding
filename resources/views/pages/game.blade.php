@extends('layouts.app')

@section('content')
    {{-- Oyun & Canlı: Sıralama, anlık duyurular, kartlar, rozetler, görevler, mentor/test --}}
    <section id="game-hero" class="min-h-[40vh] flex items-center justify-center px-6 py-16 bg-dark-900 border-b border-white/10">
        <div class="text-center">
            <span class="section-voice-label text-amethyst-200/90 text-xs font-mono tracking-widest uppercase block mb-2">Canlı</span>
            <h1 class="font-cinzel text-3xl sm:text-4xl font-bold text-parchment-100 mb-2">Oyun & Sıralama</h1>
            <p class="text-parchment-400 text-sm max-w-xl mx-auto">Anlık duyurular, liderlik tabloları, kartlar, rozetler ve görevler.</p>
            <a href="{{ route('welcome') }}#hero" class="inline-block mt-6 text-amethyst-100 hover:text-amethyst-200 text-sm font-medium">← Tanıtım sayfasına dön</a>
        </div>
    </section>

    @include('partials.live-feed', ['feedItems' => $feedItems ?? []])
    @include('partials.leaderboard', ['leaderboardTeams' => $leaderboardTeams ?? [], 'leaderboardParticipants' => $leaderboardParticipants ?? [], 'leaderboardViewers' => $leaderboardViewers ?? []])
    @include('partials.card-market', ['cards' => $cards ?? []])
    @include('partials.quest-board', ['quests' => $quests ?? collect()])
    @include('partials.badge-gallery', ['badges' => $badges ?? []])
    @include('partials.mentor-tester', ['teamsForSelect' => $teamsForSelect ?? []])
@endsection
