<section class="services section" id="services" aria-labelledby="services-title"><div class="container">
<p class="section-label">{{ preg_replace('/^\d+\s*\/\s*/', '', $copy['label'] ?? 'Services') }}</p>
<h2 id="services-title" class="section-title section-title--offset">@foreach(($copy['headline'] ?? []) as $line)<span>{{ $line }}</span>@endforeach</h2>
<div class="services__board"><div class="services__visual" aria-hidden="true"><div class="services__visual-label">Sound production system</div>
@foreach($services as $service)<img class="services__visual-image services__visual-image--{{ $service['number'] }}" src="{{ $service['image'] }}" alt="">@endforeach
<div class="services__visual-wave">@for($i=0;$i<38;$i++)<span style="--i:{{ $i }}"></span>@endfor</div></div>
<div class="services__rows">@foreach($services as $service)<a class="service-row" href="{{ url($service['href']) }}"><span class="service-row__number">{{ $service['number'] }}</span><span class="service-row__content"><strong>{{ $service['title'][$locale] }}</strong><em>{{ str_replace(' / ', ' / ', $service['meta'][$locale]) }} ↗</em></span></a>@endforeach</div></div>
</div></section>
