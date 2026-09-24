@php
$playLabel = soundiaLabel($labels ?? [], 'audio.play', $locale === 'ru' ? 'Воспроизвести фрагмент' : ($locale === 'lv' ? 'Atskaņot fragmentu' : 'Play preview'));
$pauseLabel = soundiaLabel($labels ?? [], 'audio.pause', $locale === 'ru' ? 'Пауза' : ($locale === 'lv' ? 'Pauze' : 'Pause'));
@endphp
<div class="audio-player audio-player--waveform">
  <audio src="{{ $src }}" preload="none"></audio>
  <button class="audio-player__button" type="button" aria-label="{{ $playLabel }}" data-play="{{ $playLabel }}" data-pause="{{ $pauseLabel }}">
    <span class="audio-player__play-icon" aria-hidden="true"></span>
  </button>
  <div class="audio-player__wave" aria-hidden="true">
    @foreach([22,34,42,30,54,46,38,58,44,62,36,50,72,40,55,32,46,66,38,58,30,42,52,34,48,40,60,36,54,44] as $i => $height)
      <span style="--h: {{ $height }}%; --d: {{ $i * -48 }}ms"></span>
    @endforeach
  </div>
  @if($duration)<em class="audio-player__time">{{ $duration }}</em>@endif
</div>
