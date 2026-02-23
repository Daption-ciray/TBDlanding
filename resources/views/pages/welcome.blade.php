@extends('layouts.app')

@section('content')
    @include('partials.hero', ['event' => $event, 'countdownTarget' => $countdownTarget, 'stats' => $stats, 'role' => $role ?? 'adem'])
    @include('partials.hakkinda', ['stats' => $stats, 'event' => $event])
    @include('partials.konsept', ['role' => $role ?? 'adem'])
    @include('partials.timeline', ['phases' => $phases])
    @include('partials.sss', ['faqs' => $faqs, 'contact' => $contact])
    @include('partials.cta', ['event' => $event, 'sponsorTiers' => $sponsorTiers, 'contact' => $contact])
@endsection
