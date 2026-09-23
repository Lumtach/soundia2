<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

class SoundiaContent
{
    private const LANG_IDS = [
        1 => 'ru',
        2 => 'lv',
        3 => 'en',
    ];

    public static function load(): array
    {
        $content = json_decode(file_get_contents(resource_path('data/site-content.json')), true);

        try {
            $content['pages'] = self::pages();
            $content['contacts'] = self::contacts($content['contacts'] ?? []);
            $content['projects'] = self::portfolio($content['projects'] ?? []);
            $content['services'] = self::services($content['services'] ?? []);
        } catch (Throwable $exception) {
            report($exception);
        }

        return $content;
    }

    private static function contacts(array $fallback): array
    {
        if (! self::hasTables(['settings'])) {
            return $fallback;
        }

        $row = DB::table('settings')->orderBy('id')->first();
        if (! $row) {
            return $fallback;
        }

        $email = self::firstFilled($row, ['info_mail', 'admin_mail', 'partner_mail']) ?: ($fallback['email'] ?? '');
        $phone = self::firstFilled($row, ['info_phone']) ?: ($fallback['phone'] ?? '');
        $address = self::firstFilled($row, ['address']) ?: ($fallback['address'] ?? '');
        $messaging = self::firstFilled($row, ['telegram', 'skype']) ?: ($fallback['messaging'] ?? '');
        $globalAudio = self::firstFilled($row, ['site_audio', 'global_audio', 'background_audio', 'audio', 'music']);

        $socials = array_map(function (array $social) {
            $social['label'] = strtolower((string) ($social['label'] ?? ''));

            return $social;
        }, $fallback['socials'] ?? []);
        $socialMap = [
            'instagram' => self::firstFilled($row, ['instagram', 'insta']),
            'facebook' => self::firstFilled($row, ['facebook']),
            'youtube' => self::firstFilled($row, ['youtube']),
            'telegram' => self::firstFilled($row, ['telegram']),
            'twitter' => self::firstFilled($row, ['twitter']),
            'google' => self::firstFilled($row, ['google', 'gplus']),
            'vk' => self::firstFilled($row, ['vk']),
            'skype' => self::firstFilled($row, ['skype']),
            'tripadvisor' => self::firstFilled($row, ['tripvisor']),
        ];

        foreach ($socialMap as $label => $href) {
            if ($href === '') {
                continue;
            }

            $existing = array_search($label, array_column($socials, 'label'), true);
            if ($existing === false) {
                $socials[] = ['label' => $label, 'href' => $href];
                continue;
            }

            $socials[$existing]['href'] = $href;
        }

        return array_merge($fallback, [
            'email' => $email,
            'phone' => $phone,
            'messaging' => $messaging,
            'address' => $address,
            'globalAudio' => $globalAudio !== '' ? self::publicUpload('audio', $globalAudio) : ($fallback['globalAudio'] ?? ''),
            'socials' => $socials,
        ]);
    }
    private static function pages(): array
    {
        if (! self::hasTables(['pages', 'pages_langs'])) {
            return [];
        }

        $rows = DB::table('pages')
            ->where(function ($query) {
                $query->where('_on', 1)->orWhereNull('_on');
            })
            ->orderBy('_order')
            ->orderBy('id')
            ->get();

        if ($rows->isEmpty()) {
            return [];
        }

        $langs = DB::table('pages_langs')->get()->groupBy('page_id');
        $pages = [];

        foreach ($rows as $row) {
            $alias = trim((string) ($row->alias ?: $row->id));
            $pageLangs = $langs->get($row->id, collect());

            $pages[$alias] = [
                'id' => (int) $row->id,
                'alias' => $alias,
                'title' => self::localized($pageLangs, 'title', (string) ($row->title ?? $alias)),
                'short' => self::localized($pageLangs, 'short', ''),
                'description' => self::localized($pageLangs, 'descr', ''),
                'includes' => self::localized($pageLangs, 'includes', ''),
                'metaTitle' => self::localized($pageLangs, 'meta_title', ''),
                'metaDescription' => self::localized($pageLangs, 'meta_descr', ''),
                'metaKeywords' => self::localized($pageLangs, 'meta_keys', ''),
                'image' => ! empty($row->icon) ? self::publicUpload('pages', $row->icon) : '',
                'href' => $alias === 'home' ? '/' : '/' . $alias,
            ];
        }

        return $pages;
    }
    private static function portfolio(array $fallback): array
    {
        if (! self::hasTables(['portfolio', 'portfolio_langs'])) {
            return $fallback;
        }

        $rows = DB::table('portfolio')
            ->where(function ($query) {
                $query->where('_on', 1)->orWhereNull('_on');
            })
            ->orderBy('sort')
            ->orderBy('id')
            ->get();

        if ($rows->isEmpty()) {
            return $fallback;
        }

        $langs = DB::table('portfolio_langs')->get()->groupBy('portfolio_id');
        $images = self::hasTables(['portfolio_images'])
            ? DB::table('portfolio_images')->where('active', 1)->orderByDesc('main')->orderBy('sort')->get()->groupBy('portfolio_id')
            : collect();
        $audios = self::hasTables(['portfolio_audios'])
            ? DB::table('portfolio_audios')->orderBy('id')->get()->groupBy('portfolio_id')
            : collect();

        return $rows->map(function ($row) use ($langs, $images, $audios) {
            $projectLangs = $langs->get($row->id, collect());
            $projectImages = $images->get($row->id, collect());
            $projectAudios = $audios->get($row->id, collect());

            $title = self::localized($projectLangs, 'title', $row->names ?: $row->alias);
            $descriptionLocales = self::localizedExact($projectLangs, 'descr');
            $summary = self::localized($projectLangs, 'short', '');
            $description = self::localized($projectLangs, 'descr', '');
            $summary = self::fillLocalizedFallback($summary, $description);
            $description = self::fillLocalizedFallback($description, $summary);
            $audio = self::firstAudio($projectLangs, $projectAudios);
            $image = self::portfolioImage($row, $projectImages);

            return [
                'id' => $row->alias ?: (string) $row->id,
                'title' => $title,
                'category' => self::category((int) ($row->types ?? 0)),
                'summary' => $summary,
                'description' => $description,
                'availableLocales' => array_keys(array_filter($descriptionLocales, fn ($value) => $value !== '')),
                'image' => $image,
                'audioUrl' => $audio ? self::publicUpload('portfolio/audio', $audio) : null,
                'duration' => '',
                'location' => '',
                'year' => optional($row->created_at ? date_create((string) $row->created_at) : null)->format('Y') ?: '',
                'scope' => self::scope(),
                'href' => '/' . ($row->alias ?: $row->id),
            ];
        })->values()->all();
    }

    private static function services(array $fallback): array
    {
        if (! self::hasTables(['services', 'service_langs'])) {
            return $fallback;
        }

        $rows = DB::table('services')
            ->where(function ($query) {
                $query->where('_on', 1)->orWhereNull('_on');
            })
            ->orderBy('sort')
            ->orderBy('id')
            ->get();

        if ($rows->isEmpty()) {
            return $fallback;
        }

        $langs = DB::table('service_langs')->get()->groupBy('service_id');
        $audios = self::hasTables(['service_audios'])
            ? DB::table('service_audios')->orderBy('id')->get()->groupBy('service_id')
            : collect();
        $steps = self::hasTables(['service_steps'])
            ? DB::table('service_steps')->orderBy('sort')->orderBy('id')->get()->groupBy('service_id')
            : collect();

        return $rows->map(function ($row, int $index) use ($langs, $audios, $steps) {
            $serviceLangs = $langs->get($row->id, collect());
            $serviceAudios = $audios->get($row->id, collect());
            $serviceSteps = $steps->get($row->id, collect());
            $alias = $row->alias ?? $row->slug ?? $row->id;
            $title = self::localized($serviceLangs, 'title', (string) ($row->names ?? $alias));
            $meta = self::localized($serviceLangs, 'short', '');
            $description = self::localized($serviceLangs, 'descr', '');
            $meta = self::fillLocalizedFallback($meta, $description);
            $description = self::fillLocalizedFallback($description, $meta);
            $audio = self::firstAudio(collect(), $serviceAudios);

            return [
                'id' => (string) $alias,
                'number' => str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
                'title' => $title,
                'meta' => $meta,
                'description' => $description,
                'steps' => self::serviceSteps($serviceSteps),
                'image' => self::serviceImage($row),
                'audioLabel' => self::localized($serviceAudios, 'title', ''),
                'orderLabel' => self::localized($serviceLangs, 'title', (string) ($row->names ?? $alias)),
                'audioUrl' => $audio ? self::publicUpload('services/audio', $audio) : null,
                'duration' => '',
                'href' => '/services/' . $alias,
            ];
        })->values()->all();
    }


    private static function serviceSteps($rows): array
    {
        if ($rows->isEmpty()) {
            return [];
        }

        $grouped = [];
        foreach ($rows as $row) {
            $sort = (int) ($row->sort ?? $row->id ?? 0);
            $locale = self::LANG_IDS[(int) ($row->lang_id ?? 0)] ?? 'ru';
            $text = trim((string) ($row->title ?? $row->name ?? $row->text ?? ''));
            if ($text === '') {
                continue;
            }
            $grouped[$sort][$locale] = $text;
        }

        ksort($grouped);

        return array_values(array_map(function (array $step) {
            foreach (['lv', 'ru', 'en'] as $source) {
                if (! empty($step[$source])) {
                    return [
                        'ru' => $step['ru'] ?? $step[$source],
                        'lv' => $step['lv'] ?? $step[$source],
                        'en' => $step['en'] ?? $step[$source],
                    ];
                }
            }

            return ['ru' => '', 'lv' => '', 'en' => ''];
        }, $grouped));
    }

    private static function serviceImage(object $row): string
    {
        foreach (['card_pic', 'pic', 'image', 'headpic'] as $field) {
            $file = trim((string) ($row->{$field} ?? ''));
            if ($file !== '') {
                return self::publicUpload('services', $file);
            }
        }

        return '';
    }
    private static function hasTables(array $tables): bool
    {
        foreach ($tables as $table) {
            if (! Schema::hasTable($table)) {
                return false;
            }
        }

        return true;
    }

    private static function localized($rows, string $field, string $fallback = ''): array
    {
        $values = ['ru' => $fallback, 'lv' => $fallback, 'en' => $fallback];

        foreach ($rows as $row) {
            $locale = self::localeFromRow($row);
            if (! $locale || ! isset($row->{$field}) || trim((string) $row->{$field}) === '') {
                continue;
            }

            $values[$locale] = trim(strip_tags((string) $row->{$field}));
        }

        foreach (['lv', 'ru', 'en'] as $source) {
            if ($values[$source] !== '') {
                foreach ($values as $locale => $value) {
                    if ($value === '') {
                        $values[$locale] = $values[$source];
                    }
                }
                break;
            }
        }

        return $values;
    }

    private static function localizedExact($rows, string $field): array
    {
        $values = ['ru' => '', 'lv' => '', 'en' => ''];

        foreach ($rows as $row) {
            $locale = self::localeFromRow($row);
            if (! $locale || ! isset($row->{$field})) {
                continue;
            }

            $value = trim(strip_tags((string) $row->{$field}));
            if ($value !== '') {
                $values[$locale] = $value;
            }
        }

        return $values;
    }
    private static function localeFromRow(object $row): ?string
    {
        $id = (int) ($row->lang_id ?? $row->lang ?? 0);

        return self::LANG_IDS[$id] ?? null;
    }
    private static function fillLocalizedFallback(array $values, array $fallback): array
    {
        foreach ($values as $locale => $value) {
            if ($value === '' && ! empty($fallback[$locale])) {
                $values[$locale] = $fallback[$locale];
            }
        }

        foreach (['lv', 'ru', 'en'] as $source) {
            if (! empty($values[$source])) {
                foreach ($values as $locale => $value) {
                    if ($value === '') {
                        $values[$locale] = $values[$source];
                    }
                }
                break;
            }
        }

        return $values;
    }
    private static function portfolioImage(object $row, $images): string
    {
        $file = $row->headpic ?: null;

        if (! $file && $images->isNotEmpty()) {
            $file = $images->first()->pic;
        }

        return self::publicUpload('portfolio', $file ?: 'placeholder.jpg');
    }

    private static function firstAudio($langs, $audios): ?string
    {
        foreach ($langs as $lang) {
            if (! empty($lang->audio)) {
                return (string) $lang->audio;
            }
        }

        foreach ($audios as $audio) {
            if (! empty($audio->audio)) {
                return (string) $audio->audio;
            }
        }

        return null;
    }

    private static function firstFilled(object $row, array $fields): string
    {
        foreach ($fields as $field) {
            $value = trim((string) ($row->{$field} ?? ''));
            if ($value !== '') {
                return $value;
            }
        }

        return '';
    }
    private static function publicUpload(string $folder, ?string $file): string
    {
        $file = trim((string) $file);
        $file = ltrim($file, '/\\');

        if (preg_match('~^https?://~i', $file)) {
            return $file;
        }

        return '/upload/' . trim($folder, '/') . '/' . $file;
    }

    private static function category(int $type): array
    {
        return match ($type) {
            1 => ['ru' => 'Аудиогид', 'lv' => 'Audiogids', 'en' => 'Audio guide'],
            2 => ['ru' => 'Аудиоквест', 'lv' => 'Audiokvests', 'en' => 'Audio quest'],
            3 => ['ru' => 'Аудиоигра', 'lv' => 'Audiospēle', 'en' => 'Audio game'],
            4 => ['ru' => 'Променад-спектакль', 'lv' => 'Promenādes izrāde', 'en' => 'Promenade performance'],
            5 => ['ru' => '3D-аудио', 'lv' => '3D audio', 'en' => '3D audio'],
            default => ['ru' => 'Портфолио', 'lv' => 'Portfolio', 'en' => 'Portfolio'],
        };
    }

    private static function scope(): array
    {
        return [
            ['ru' => 'Сценарий', 'lv' => 'Scenārijs', 'en' => 'Script'],
            ['ru' => 'Запись голоса', 'lv' => 'Balss ieraksts', 'en' => 'Voice recording'],
            ['ru' => 'Звуковой дизайн', 'lv' => 'Skaņas dizains', 'en' => 'Sound design'],
        ];
    }
}












