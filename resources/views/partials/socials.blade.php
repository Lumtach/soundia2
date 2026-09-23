<div class="{{ $class ?? '' }}" aria-label="Social links">
@foreach(($content['contacts']['socials'] ?? []) as $social)
  @php($label = strtolower($social['label']))
  <a class="social-link social-link--{{ $label }}" href="{{ $social['href'] }}" target="_blank" rel="noreferrer" aria-label="{{ $social['label'] }}">
    @if($label === 'instagram')
      <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><rect x="3" y="3" width="18" height="18" rx="5"></rect><circle cx="12" cy="12" r="4"></circle><circle cx="17.5" cy="6.5" r="1.2"></circle></svg>
    @elseif($label === 'facebook')
      <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M14 8h3V4h-3c-3.1 0-5 1.9-5 5v2H6v4h3v5h4v-5h3.2l.8-4h-4V9c0-.7.3-1 1-1Z"></path></svg>
    @else
      <span>{{ $social['label'] }}</span>
    @endif
  </a>
@endforeach
</div>
