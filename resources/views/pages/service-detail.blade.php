@extends('layouts.soundia')
@section('content')
@php
$service = collect($content['services'])->firstWhere('id', $slug);
abort_unless($service, 404);
$processTitle = $locale === 'ru' ? 'Как мы работаем' : ($locale === 'lv' ? 'Kā mēs strādājam' : 'How we work');
$requestText = $locale === 'ru'
  ? 'Оставьте заявку, и мы подберём формат под ваш проект.'
  : ($locale === 'lv'
    ? 'Nosūtiet pieprasījumu, un mēs pielāgosim formātu jūsu projektam.'
    : 'Send a request and we will shape the format around your project.');
@endphp
<main class="service-detail-page service-detail-page--single-photo">
  <div class="service-page-shell">
    <figure class="service-page-shell__media" aria-hidden="true">
      <img src="{{ $service['image'] }}" alt="">
    </figure>

    <div class="service-page-shell__content">
      <section class="service-hero-panel" aria-labelledby="service-detail-title">
        <div class="service-hero-panel__topline">
          <a class="service-hero-panel__back" href="{{ url('/services') }}" aria-label="{{ $nav['services'] }}">←</a>
          <p class="service-hero-panel__meta">{{ $service['meta'][$locale] }}</p>
        </div>
        <h1 id="service-detail-title">{{ $service['title'][$locale] }}</h1>
        <p class="service-hero-panel__lead">{{ $service['description'][$locale] }}</p>
        @if(!empty($service['audioUrl']))
          <div class="service-hero-panel__audio">
            @include('partials.audio-player', ['src'=>$service['audioUrl'], 'duration'=>$service['duration'] ?? ''])
          </div>
        @endif
      </section>

      <section class="service-work-panel" aria-labelledby="service-process-title">
        <div class="service-work-panel__main">
          <h2 id="service-process-title">{{ $processTitle }}</h2>
          <ol class="service-work-list">
            @foreach($service['steps'] as $step)
              <li><span aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><strong>{{ $step[$locale] }}</strong></li>
            @endforeach
          </ol>
        </div>
        <aside class="service-work-panel__aside">
          <p>{{ $requestText }}</p>
          <button class="button button--lg button--arrow-end service-work-panel__order" type="button" data-modal-open="order-modal">{{ $service['orderLabel'][$locale] }}</button>
        </aside>
      </section>
    </div>
  </div>
</main>
@endsection


