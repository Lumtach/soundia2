<?php

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

function soundiaData(array $extra = []): array
{
    $content = json_decode(file_get_contents(resource_path('data/site-content.json')), true);
    $locale = soundiaResolveLocale($content);

    $dict = $content['dictionaries'][$locale];

    return array_merge([
        'content' => $content,
        'locale' => $locale,
        'dict' => $dict,
        'nav' => $dict['nav'],
        'contacts' => $content['contacts'],
        'title' => $dict['seo']['title'] ?? 'Soundia',
        'description' => $dict['seo']['description'] ?? 'Soundia creative audio studio',
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


