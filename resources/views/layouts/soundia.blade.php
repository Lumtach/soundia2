@php
    $content = $content ?? json_decode(file_get_contents(resource_path('data/site-content.json')), true);
    $locale = $locale ?? (function_exists('soundiaResolveLocale') ? soundiaResolveLocale($content) : ($content['meta']['defaultLocale'] ?? 'lv'));
    if (!in_array($locale, $content['meta']['locales'], true)) { $locale = $content['meta']['defaultLocale'] ?? 'lv'; }
    $dict = $dict ?? $content['dictionaries'][$locale];
    $nav = $nav ?? $dict['nav'];
    $contacts = $contacts ?? $content['contacts'];
    $title = $title ?? ($dict['seo']['title'] ?? 'Soundia');
    $description = $description ?? ($dict['seo']['description'] ?? 'Soundia creative audio studio');
@endphp
<!doctype html>
<html lang="{{ $locale }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('partials.header', compact('locale', 'nav', 'contacts', 'content'))
    @yield('content')
    @include('partials.footer', compact('locale', 'nav', 'contacts', 'dict', 'content'))
</body>
</html>


