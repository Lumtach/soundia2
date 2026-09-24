<header class="site-header">
  <a class="site-header__brand" href="{{ url('/') }}">
    <img class="site-header__logo" src="{{ asset('logo.svg') }}" alt="Soundia Creative Studio" width="255" height="100">
  </a>
  <div class="site-header__right">
    <button class="global-audio-toggle" type="button" aria-label="{{ soundiaLabel($labels ?? [], 'audio.toggle', 'Toggle audio') }}"><span></span></button>
    <details class="language-dropdown">
      <summary aria-label="{{ soundiaLabel($labels ?? [], 'language.select', 'Select language') }}"><span class="language-dropdown__globe" aria-hidden="true"></span><span class="language-dropdown__current">{{ strtoupper($locale) }}</span></summary>
      <div class="language-dropdown__menu">
        @foreach (['ru' => 'Русский', 'lv' => 'Latviešu', 'en' => 'English'] as $code => $label)
          <a class="{{ $code === $locale ? 'is-active' : '' }}" href="{{ route('locale.set', $code) }}"><span>{{ strtoupper($code) }}</span><small class="visually-hidden">{{ $label }}</small></a>
        @endforeach
      </div>
    </details>
    <div class="mobile-menu">
      <button class="mobile-menu__toggle" type="button" data-menu-open aria-label="{{ soundiaLabel($labels ?? [], 'menu.open', 'Open menu') }}"><span aria-hidden="true"></span></button>
      <div class="mobile-menu__overlay" role="dialog" aria-modal="true">
        <aside class="mobile-menu__panel">
          <div class="mobile-menu__top"><button class="mobile-menu__close" type="button" data-menu-close aria-label="{{ soundiaLabel($labels ?? [], 'menu.close', 'Close menu') }}"><span aria-hidden="true"></span></button></div>
          <div class="mobile-menu__content">
            <nav class="mobile-menu__nav" aria-label="Mobile navigation">
              <a href="{{ url('/') }}">{{ soundiaLabel($labels ?? [], 'nav.home', $nav['home'] ?? ($locale === 'ru' ? 'Главная' : ($locale === 'lv' ? 'Sākums' : 'Home'))) }}</a>
              <a href="{{ url('/about-company') }}">{{ $nav['about'] }}</a>
              <a href="{{ url('/services') }}">{{ $nav['services'] }}</a>
              <a href="{{ url('/portfolio') }}">{{ $nav['work'] }}</a>
              <a href="{{ url('/pricing') }}">{{ $nav['pricing'] }}</a>
              <a href="{{ url('/courses') }}">{{ $nav['courses'] }}</a>
            </nav>
            <div class="mobile-menu__bottom">
              <address class="mobile-menu__contacts">
                <a href="mailto:{{ $contacts['email'] ?? 'info@soundia.studio' }}">{{ $contacts['email'] ?? 'info@soundia.studio' }}</a>
                <a href="tel:{{ preg_replace('/\s+/', '', $contacts['phone'] ?? '') }}">{{ $contacts['phone'] ?? '' }}</a>
                <span>{{ $contacts['messaging'] ?? '' }}</span><span>{{ $contacts['address'] ?? '' }}</span>
              </address>
              @include('partials.socials', ['class' => 'mobile-menu__socials'])
            </div>
          </div>
        </aside>
      </div>
    </div>
  </div>
</header>

