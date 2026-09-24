<?php

use App\Support\SoundiaContent;
use Illuminate\Support\Facades\Route;

function soundiaResolveLocale(array $content): string
{
    $locales = $content['meta']['locales'] ?? ['ru', 'lv', 'en'];
    $default = $content['meta']['defaultLocale'] ?? 'lv';
    $current = session('locale');

    if (is_string($current) && in_array($current, $locales, true)) {
        return $current;
    }

    session()->forget(['locale', 'locale_manual']);

    $header = request()->server('HTTP_ACCEPT_LANGUAGE', '');
    $candidates = [];

    foreach (explode(',', $header) as $part) {
        $part = trim($part);
        if ($part === '') {
            continue;
        }

        [$tag, $quality] = array_pad(explode(';q=', $part, 2), 2, '1');
        $code = strtolower(substr(trim($tag), 0, 2));
        $candidates[] = ['code' => $code, 'quality' => (float) $quality];
    }

    usort($candidates, fn ($a, $b) => $b['quality'] <=> $a['quality']);

    foreach ($candidates as $candidate) {
        if (in_array($candidate['code'], $locales, true)) {
            session(['locale' => $candidate['code'], 'locale_auto' => true]);
            return $candidate['code'];
        }
    }

    session(['locale' => $default, 'locale_auto' => true]);
    return $default;
}

function soundiaLabel(array $labels, string $key, string $fallback = ''): string
{
    return trim((string) ($labels[$key] ?? '')) ?: $fallback;
}

function soundiaPageTitle(array $pages, string $alias, string $locale, string $fallback): string
{
    $title = $pages[$alias]['title'][$locale] ?? '';

    return trim((string) $title) ?: $fallback;
}

function soundiaNav(array $content, string $locale, array $fallback): array
{
    $pages = $content['pages'] ?? [];

    return array_merge($fallback, [
        'home' => soundiaPageTitle($pages, 'mains', $locale, $fallback['home'] ?? 'Home'),
        'work' => soundiaPageTitle($pages, 'portfolio', $locale, $fallback['work'] ?? 'Portfolio'),
        'services' => soundiaPageTitle($pages, 'services', $locale, $fallback['services'] ?? 'Services'),
        'pricing' => soundiaPageTitle($pages, 'prices', $locale, $fallback['pricing'] ?? 'Pricing'),
        'about' => soundiaPageTitle($pages, 'about-company', $locale, $fallback['about'] ?? 'About'),
        'courses' => soundiaPageTitle($pages, 'courses', $locale, $fallback['courses'] ?? 'Courses'),
    ]);
}
function soundiaCurrentPageAlias(): string
{
    $routeName = request()->route()?->getName();

    return match ($routeName) {
        'home' => 'mains',
        'portfolio' => 'portfolio',
        'services' => 'services',
        'pricing' => 'prices',
        'about' => 'about-company',
        default => trim(request()->path(), '/') ?: 'home',
    };
}
function soundiaData(array $extra = []): array
{
    $content = SoundiaContent::load();
    $locale = soundiaResolveLocale($content);

    $content['projects'] = array_values(array_filter($content['projects'] ?? [], function (array $project) use ($locale) {
        $availableLocales = $project['availableLocales'] ?? null;

        return ! is_array($availableLocales) || in_array($locale, $availableLocales, true);
    }));

    $dict = $content['dictionaries'][$locale];
    $labels = $content['labels'][$locale] ?? [];
    $nav = soundiaNav($content, $locale, $dict['nav'] ?? []);
    $pageAlias = soundiaCurrentPageAlias();
    $page = $content['pages'][$pageAlias] ?? null;
    $pageTitle = is_array($page) ? ($page['metaTitle'][$locale] ?: ($page['title'][$locale] ?? '')) : '';
    $pageDescription = is_array($page) ? ($page['metaDescription'][$locale] ?: ($page['short'][$locale] ?? '')) : '';

    return array_merge([
        'content' => $content,
        'locale' => $locale,
        'dict' => $dict,
        'nav' => $nav,
        'contacts' => $content['contacts'],
        'labels' => $labels,
        'pageRecord' => $page,
        'title' => $pageTitle ?: ($dict['seo']['title'] ?? 'Soundia'),
        'description' => $pageDescription ?: ($dict['seo']['description'] ?? 'Soundia creative audio studio'),
    ], $extra);
}

function soundiaView(string $view, array $extra = [])
{
    return view($view, soundiaData($extra));
}

Route::get('/set-locale/{locale}', function (string $locale) {
    abort_unless(in_array($locale, ['ru', 'lv', 'en'], true), 404);
    session(['locale' => $locale, 'locale_manual' => true, 'locale_auto' => false]);
    return back();
})->name('locale.set');

Route::get('/', fn () => soundiaView('pages.home'))->name('home');
Route::get('/portfolio', fn () => soundiaView('pages.portfolio'))->name('portfolio');
Route::get('/services', fn () => soundiaView('pages.services'))->name('services');
Route::get('/pricing', fn () => soundiaView('pages.pricing'))->name('pricing');
Route::get('/courses', fn () => soundiaView('pages.courses'))->name('courses');
Route::get('/about-company', fn () => soundiaView('pages.about'))->name('about');

Route::get('/services/{slug}', fn (string $slug) => soundiaView('pages.service-detail', ['slug' => $slug]))->name('services.show');
Route::get('/courses/{slug}', fn (string $slug) => soundiaView('pages.course-detail', ['slug' => $slug]))->name('courses.show');
Route::get('/{slug}', fn (string $slug) => soundiaView('pages.project-detail', ['slug' => $slug]))->where('slug', '^(?!api|build|storage).+')->name('projects.show');







