<?php

namespace App\Support\PublicSite;

use Illuminate\Support\Arr;
use RuntimeException;

final class PublicFixtureRepository
{
    /** @var array<int, string> */
    public const LOCALES = ['ja', 'en', 'zh', 'ko'];

    /** @var array<int, string> */
    public const FIXTURES = ['site', 'footer', 'prices', 'items', 'process', 'company', 'news', 'contact'];

    /**
     * @return array<string, mixed>
     */
    public function get(string $locale, string $name): array
    {
        if (! in_array($locale, self::LOCALES, true) || ! in_array($name, self::FIXTURES, true)) {
            throw new RuntimeException('Invalid public fixture request.');
        }

        $path = resource_path("data/public/{$locale}/{$name}.json");

        if (! is_file($path) || ! is_readable($path)) {
            throw new RuntimeException("Public fixture [{$locale}/{$name}] is unavailable.");
        }

        $decoded = json_decode((string) file_get_contents($path), true, flags: JSON_THROW_ON_ERROR);

        if (! is_array($decoded)) {
            throw new RuntimeException("Public fixture [{$locale}/{$name}] must contain a JSON object.");
        }

        return $decoded;
    }

    /**
     * @param  array<int, string>  $names
     * @return array<string, array<string, mixed>>
     */
    public function many(string $locale, array $names): array
    {
        return collect($names)->mapWithKeys(fn (string $name): array => [$name => $this->get($locale, $name)])->all();
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findNewsBySlug(string $locale, string $slug): ?array
    {
        return collect($this->get($locale, 'news')['items'] ?? [])->firstWhere('slug', $slug);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findNewsByArticleKey(string $locale, string $articleKey): ?array
    {
        return collect($this->get($locale, 'news')['items'] ?? [])->firstWhere('article_key', $articleKey);
    }

    public function hasLocale(string $locale): bool
    {
        return in_array($locale, self::LOCALES, true);
    }

    public function value(string $locale, string $fixture, string $key, mixed $default = null): mixed
    {
        return Arr::get($this->get($locale, $fixture), $key, $default);
    }
}
