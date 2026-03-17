@extends('layouts.app')

@section('content')
    @php $activeRole = $role ?? 'kasif'; @endphp

    @include('partials.hero', [
        'event' => $event, 
        'countdownTarget' => $countdownTarget, 
        'stats' => $stats, 
        'role' => $activeRole,
        'statusText' => $statusText ?? 'STABİL',
        'syncPercent' => $syncPercent ?? 0
    ])
    @include('partials.hakkinda', ['stats' => $stats, 'event' => $event, 'role' => $activeRole])
    @include('partials.konsept', ['role' => $activeRole])
    @include('partials.timeline', ['phases' => $phases, 'role' => $activeRole])
    @include('partials.sss', ['faqs' => $faqs, 'contact' => $contact, 'role' => $activeRole])
    @include('partials.cta', ['event' => $event, 'sponsorTiers' => $sponsorTiers, 'contact' => $contact, 'role' => $activeRole])
@endsection
