@extends('layouts.soundia')
@section('content')
@php
$project = collect($content['projects'])->firstWhere('id', $slug);
abort_unless($project, 404);
@endphp
<main class="case-page"><section class="case-hero"><div class="container"><a class="case-back" href="{{ url('/portfolio') }}">← {{ $dict['case']['back'] ?? $nav['work'] }}</a><div class="case-hero__grid"><div><p class="section-label">{{ $project['category'][$locale] }}</p><h1>{{ $project['title'][$locale] }}</h1><p>{{ $project['summary'][$locale] }}</p>@if(!empty($project['audioUrl']))@include('partials.audio-player', ['src'=>$project['audioUrl'], 'duration'=>$project['duration'] ?? ''])@endif<button class="button button--lg button--arrow-end" type="button" data-modal-open="order-modal">{{ $dict['case']['orderAudioGuide'] ?? 'Order' }}</button></div><figure><img src="{{ $project['image'] }}" alt="{{ $project['title'][$locale] }}"></figure></div></div></section><section class="case-details section"><div class="container"><h2>{{ $dict['case']['facts'] ?? 'Project facts' }}</h2><dl class="case-facts"><div><dt>{{ $dict['case']['type'] ?? 'Type' }}</dt><dd>{{ $project['category'][$locale] }}</dd></div><div><dt>{{ $dict['case']['place'] ?? 'Place' }}</dt><dd>{{ $project['location'] }}</dd></div><div><dt>{{ $dict['case']['year'] ?? 'Year' }}</dt><dd>{{ $project['year'] }}</dd></div></dl><ul class="case-scope">@foreach($project['scope'] as $scope)<li>{{ $scope[$locale] }}</li>@endforeach</ul></div></section></main>
@endsection
