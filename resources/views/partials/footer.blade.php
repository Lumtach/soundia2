<footer class="footer">
  <div class="footer__inner">
    <div class="footer__columns">
      <div class="footer__brand" aria-label="Soundia Creative Studio"><img class="footer__logo" src="{{ asset('logo.svg') }}" alt="Soundia Creative Studio" width="205" height="95"></div>
      <nav class="footer__nav" aria-label="Footer navigation">
        <a href="{{ url('/portfolio') }}">{{ $nav['work'] }}</a><a href="{{ url('/services') }}">{{ $nav['services'] }}</a><a href="{{ url('/pricing') }}">{{ $nav['pricing'] }}</a><a href="{{ url('/about-company') }}">{{ $nav['about'] }}</a><a href="{{ url('/courses') }}">{{ $nav['courses'] }}</a>
      </nav>
      <div class="footer__contact-column"><address class="footer__contacts"><a href="mailto:{{ $contacts['email'] }}">{{ $contacts['email'] }}</a><a href="tel:{{ preg_replace('/\s+/', '', $contacts['phone']) }}">{{ $contacts['phone'] }}</a><span>{{ $contacts['messaging'] }}</span><span>{{ $contacts['address'] }}</span></address></div>
    </div>
    <div class="footer__bottom"><p>{{ $dict['footer']['copyright'] }}</p>@include('partials.socials', ['class' => 'footer__socials'])</div>
  </div>
</footer>
@include('partials.order-modal')
