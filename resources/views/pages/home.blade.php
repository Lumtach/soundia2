@extends('layouts.soundia')
@section('content')
@php
$home = $dict['home'];
@endphp
<main class="home-page home-page--hero-only">
<section class="hero" aria-labelledby="hero-title"><div class="container"><div class="hero__grid">
<p class="hero__eyebrow">{{ $home['hero']['eyebrow'] }}</p>
<h1 id="hero-title" class="hero__title" lang="{{ $locale }}">@foreach($home['hero']['headline'] as $i=>$line)<span class="hero__line hero__line--{{ $i+1 }}">{{ $line }}</span>@endforeach</h1>
<ul class="hero__meta" aria-label="Soundia services">@foreach($home['hero']['meta'] as $item)<li>{{ $item }}</li>@endforeach</ul>
<a class="button button--lg button--arrow-end hero__cta" href="{{ url('/portfolio') }}">{{ $home['hero']['cta'] }}</a>
<div class="ar-field is-paused" style="--scan-x:62%;--scan-y:50%"><div class="ar-field__equalizer" aria-hidden="true">@foreach([38,72,54,86,46,92,62,78,42,96,68,50,82,58,90,44,74,62,88,52,80,40,70,94,56,84,48,76,60,91,45,68,55,83,50,73,39] as $i=>$h)<span style="--bar-height:{{ $h }}%;--delay:{{ $i * -90 }}ms"></span>@endforeach</div></div>
<span class="hero__scroll">{{ $home['hero']['scroll'] }}</span>
</div></div></section>
</main>
@endsection
