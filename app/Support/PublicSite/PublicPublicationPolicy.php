<?php

namespace App\Support\PublicSite;

use Illuminate\Support\Arr;

final class PublicPublicationPolicy
{
    public function __construct(private readonly PublicFixtureRepository $fixtures) {}

    /**
     * @param  array<string, mixed>|null  $article
     * @return array{translation_status:string,page_status:string,is_indexable:bool}
     */
    public function status(string $locale, string $pageKey, ?array $article = null): array
    {
        $site = $this->fixtures->get($locale, 'site');
        $status = [
            'translation_status' => (string) Arr::get($site, 'publication.translation_status', 'review'),
            'page_status' => (string) Arr::get($site, "publication.pages.{$pageKey}.page_status", 'preview'),
            'is_indexable' => (bool) Arr::get($site, "publication.pages.{$pageKey}.is_indexable", false),
        ];

        if ($pageKey === 'news_show' && $article !== null) {
            $status['page_status'] = (string) ($article['page_status'] ?? $status['page_status']);
            $status['is_indexable'] = (bool) ($article['is_indexable'] ?? $status['is_indexable']);
        }

        $overrides = config("public_site.publication_overrides.{$locale}", []);

        if (is_array($overrides)) {
            $status['translation_status'] = (string) ($overrides['translation_status'] ?? $status['translation_status']);
            $pageOverride = $overrides['pages'][$pageKey] ?? [];
            if (is_array($pageOverride)) {
                $status['page_status'] = (string) ($pageOverride['page_status'] ?? $status['page_status']);
                $status['is_indexable'] = (bool) ($pageOverride['is_indexable'] ?? $status['is_indexable']);
            }
        }

        return $status;
    }

    /** @param array{translation_status:string,page_status:string,is_indexable:bool} $status */
    public function isPublished(array $status): bool
    {
        return $status['translation_status'] === 'approved'
            && $status['page_status'] === 'published'
            && $status['is_indexable'];
    }

    /** @param array{translation_status:string,page_status:string,is_indexable:bool} $status */
    public function isIndexable(array $status): bool
    {
        return (bool) config('public_site.indexing', false) && $this->isPublished($status);
    }

    /**
     * @param  array<string, mixed>|null  $article
     */
    public function isPublicationCandidate(string $locale, string $pageKey, ?array $article = null): bool
    {
        return $this->isPublished($this->status($locale, $pageKey, $article));
    }
}
