<div class="{{ $class ?? '' }}" aria-label="Social links">
@foreach(($content['contacts']['socials'] ?? []) as $social)
  @php
    $label = strtolower((string) ($social['label'] ?? 'link'));
    $label = $label === 'x' ? 'twitter' : $label;
    $label = $label === 'tripvisor' ? 'tripadvisor' : $label;
  @endphp
  <a class="social-link social-link--{{ $label }}" href="{{ $social['href'] }}" target="_blank" rel="noreferrer" aria-label="{{ $social['label'] }}">
    @switch($label)
      @case('instagram')
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><rect x="3" y="3" width="18" height="18" rx="5"></rect><circle cx="12" cy="12" r="4"></circle><circle cx="17.5" cy="6.5" r="1.2"></circle></svg>
        @break
      @case('facebook')
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M14 8h3V4h-3c-3.1 0-5 1.9-5 5v2H6v4h3v5h4v-5h3.2l.8-4h-4V9c0-.7.3-1 1-1Z"></path></svg>
        @break
      @case('youtube')
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4.5 7.2c.2-1.2 1.1-2.1 2.3-2.3C8.8 4.5 12 4.5 12 4.5s3.2 0 5.2.4c1.2.2 2.1 1.1 2.3 2.3.4 2 .4 4.8.4 4.8s0 2.8-.4 4.8c-.2 1.2-1.1 2.1-2.3 2.3-2 .4-5.2.4-5.2.4s-3.2 0-5.2-.4c-1.2-.2-2.1-1.1-2.3-2.3-.4-2-.4-4.8-.4-4.8s0-2.8.4-4.8Z"></path><path d="m10 8.8 5 3.2-5 3.2Z"></path></svg>
        @break
      @case('telegram')
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M20.5 4.5 3.8 11c-1.1.4-1.1 1.1-.2 1.4l4.3 1.3 1.6 5c.2.6.3.8.7.8.3 0 .5-.1.8-.4l2.3-2.2 4.7 3.5c.9.5 1.5.3 1.7-.8l3-14c.3-1.2-.4-1.7-1.2-1.3Z"></path><path d="m8 13.4 9.8-6.2-7.6 7.2-.3 3.5Z"></path></svg>
        @break
      @case('twitter')
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4 4h4.2l4.2 5.6L17.1 4H20l-6.2 7.4L20.5 20h-4.2l-4.6-6.1L6.6 20H3.7l6.6-7.9Z"></path></svg>
        @break
      @case('google')
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M20.5 12.2c0-.7-.1-1.3-.2-1.9H12v3.6h4.8c-.2 1.2-.8 2.1-1.7 2.8v2.3h2.8c1.7-1.5 2.6-3.8 2.6-6.8Z"></path><path d="M12 21c2.4 0 4.4-.8 5.9-2.1l-2.8-2.3c-.8.5-1.8.8-3.1.8-2.3 0-4.3-1.6-5-3.7H4.1v2.4C5.5 19 8.5 21 12 21Z"></path><path d="M7 13.7a5.4 5.4 0 0 1 0-3.4V7.9H4.1a9 9 0 0 0 0 8.2Z"></path><path d="M12 6.6c1.3 0 2.5.4 3.4 1.3L18 5.3C16.4 3.9 14.4 3 12 3 8.5 3 5.5 5 4.1 7.9L7 10.3c.7-2.1 2.7-3.7 5-3.7Z"></path></svg>
        @break
      @case('vk')
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4 7h3.4c.2 4.2 1.9 6 3.2 6.4V7h3.2v3.7c1.2-.1 2.5-1.8 2.9-3.7H20c-.3 2.3-1.8 4-2.9 4.7 1.1.6 2.9 2 3.6 5.3h-3.5c-.5-1.9-1.7-3.3-3.4-3.5V17h-.4C8.7 17 4.5 13.8 4 7Z"></path></svg>
        @break
      @case('skype')
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M18.5 13.1c.1-.4.1-.7.1-1.1A6.6 6.6 0 0 0 12 5.4c-.4 0-.8 0-1.1.1A4.4 4.4 0 0 0 4.5 11c-.1.4-.1.7-.1 1.1a6.6 6.6 0 0 0 6.6 6.6c.4 0 .8 0 1.1-.1a4.4 4.4 0 0 0 6.4-5.5Z"></path><path d="M8.6 14.3c.8.8 2 1.1 3.4 1.1 1.7 0 3.2-.8 3.2-2.2 0-1.2-.8-1.8-2.6-2.1l-1.4-.2c-.8-.1-1.1-.3-1.1-.7 0-.5.6-.8 1.5-.8.9 0 1.6.3 2.2.8l1.1-1.1c-.8-.7-1.8-1-3.1-1-1.7 0-3 .8-3 2.1 0 1.2.8 1.8 2.5 2.1l1.4.2c.9.2 1.2.4 1.2.8 0 .5-.7.8-1.7.8-1.1 0-2-.4-2.6-1Z"></path></svg>
        @break
      @case('tripadvisor')
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M3 8.5h3.6A8 8 0 0 1 12 6.6a8 8 0 0 1 5.4 1.9H21l-2.2 2.4a5.1 5.1 0 0 1-8.2 5.9L8 19.5l-2.6-2.7a5.1 5.1 0 0 1-.2-5.9Z"></path><circle cx="8" cy="13" r="2.1"></circle><circle cx="16" cy="13" r="2.1"></circle><circle cx="8" cy="13" r=".7"></circle><circle cx="16" cy="13" r=".7"></circle></svg>
        @break
      @default
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M10.6 13.4a4 4 0 0 0 5.7 0l2.1-2.1a4 4 0 0 0-5.7-5.7l-1.2 1.2"></path><path d="M13.4 10.6a4 4 0 0 0-5.7 0l-2.1 2.1a4 4 0 0 0 5.7 5.7l1.2-1.2"></path></svg>
    @endswitch
  </a>
@endforeach
</div>
