<?php

namespace App\Http\Controllers;

use App\Support\PublicSite\PublicFixtureRepository;
use App\Support\PublicSite\PublicPublicationPolicy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class PublicSiteController extends Controller
{
    /** @var array<string, array<int, string>> */
    private const PAGE_FIXTURES = [
        'home' => ['site', 'footer', 'prices', 'items', 'process', 'company', 'news', 'contact'],
        'prices' => ['site', 'footer', 'prices', 'items', 'process', 'company', 'news', 'contact'],
        'items' => ['site', 'footer', 'prices', 'items', 'process', 'company', 'news', 'contact'],
        'process' => ['site', 'footer', 'prices', 'items', 'process', 'company', 'news', 'contact'],
        'company' => ['site', 'footer', 'prices', 'items', 'process', 'company', 'news', 'contact'],
        'news' => ['site', 'footer', 'prices', 'items', 'process', 'company', 'news', 'contact'],
        'news_show' => ['site', 'footer', 'prices', 'items', 'process', 'company', 'news', 'contact'],
        'contact' => ['site', 'footer', 'prices', 'items', 'process', 'company', 'news', 'contact'],
    ];

    public function __construct(
        private readonly PublicFixtureRepository $fixtures,
        private readonly PublicPublicationPolicy $publication,
    ) {}

    public function home(Request $request, string $locale): View { return $this->render($request, $locale, 'home', 'public.pages.home'); }
    public function prices(Request $request, string $locale): View { return $this->render($request, $locale, 'prices', 'public.pages.prices'); }
    public function items(Request $request, string $locale): View { return $this->render($request, $locale, 'items', 'public.pages.items'); }
    public function process(Request $request, string $locale): View { return $this->render($request, $locale, 'process', 'public.pages.process'); }
    public function company(Request $request, string $locale): View { return $this->render($request, $locale, 'company', 'public.pages.company'); }
    public function news(Request $request, string $locale): View { return $this->render($request, $locale, 'news', 'public.pages.news'); }
    public function contact(Request $request, string $locale): View { return $this->render($request, $locale, 'contact', 'public.pages.contact'); }

    public function newsShow(Request $request, string $locale, string $slug): View
    {
        $article = $this->fixtures->findNewsBySlug($locale, $slug);
        abort_unless($article, 404);

        return $this->render($request, $locale, 'news_show', 'public.pages.news-show', $article);
    }

    public function contactStep(string $locale): RedirectResponse
    {
        return redirect()->route('public.contact', ['locale' => $locale]);
    }

    /**
     * @param  array<string, mixed>|null  $article
     */
    private function render(Request $request, string $locale, string $pageKey, string $view, ?array $article = null): View
    {
        abort_unless($this->fixtures->hasLocale($locale), 404);

        $data = $this->fixtures->many($locale, self::PAGE_FIXTURES[$pageKey]);
        $data['site']['navigation'] = $this->resolvedNavigation($locale, $pageKey, $data['site']['navigation']);

        $routeName = (string) config("public_site.page_routes.{$pageKey}");
        $canonicalParameters = ['locale' => $locale];
        if ($pageKey === 'news_show') {
            $canonicalParameters['slug'] = $article['slug'];
        }

        $canonical = route($routeName, $canonicalParameters);
        $status = $this->publication->status($locale, $pageKey, $article);
        $robots = $this->publication->isIndexable($status) ? 'index, follow' : 'noindex, nofollow';
        $request->attributes->set('public_robots', $robots);

        $languages = $this->languageOptions($locale, $pageKey, $article);
        $alternates = $this->hreflangAlternates($pageKey, $article, $languages, $canonical);

        $payloadSite = $data['site'];
        if ($pageKey === 'home') {
            $payloadSite['ui']['utility_primary'] = $data['site']['home']['utility']['text'];
            $payloadSite['ui']['cta'] = [
                'eyebrow' => $data['site']['home']['final_cta']['eyebrow'],
                'title' => $data['site']['home']['final_cta']['title']['text'],
                'lead' => $data['site']['home']['final_cta']['lead']['text'],
                'contact' => collect($data['site']['home']['final_cta']['actions'])->firstWhere('key', 'contact')['label'] ?? '',
                'process' => $data['site']['home']['process']['link'],
            ];
        }

        $payload = [
            'locale' => $locale,
            'htmlLang' => config("public_site.locales.{$locale}.html_lang"),
            'pageKey' => $pageKey,
            'site' => $payloadSite,
            'prices' => $data['prices'],
            'news' => $data['news'],
            'contact' => $data['contact'],
            'languageOptions' => $languages,
            'urls' => [
                'contact' => route('public.contact', ['locale' => $locale]),
                'contactConfirm' => route('public.contact.confirm', ['locale' => $locale]),
                'contactComplete' => route('public.contact.complete', ['locale' => $locale]),
                'news' => route('public.news', ['locale' => $locale]),
            ],
        ];

        $actionUrls = [
            'contact' => route('public.contact', ['locale' => $locale]),
            'prices' => route('public.prices', ['locale' => $locale]),
            'items' => route('public.items', ['locale' => $locale]),
            'process' => route('public.process', ['locale' => $locale]),
            'line' => null,
        ];

        return view($view, [
            ...$data,
            'locale' => $locale,
            'pageKey' => $pageKey,
            'article' => $article,
            'canonical' => $canonical,
            'robots' => $robots,
            'languageOptions' => $languages,
            'hreflangAlternates' => $alternates,
            'publicPayload' => $payload,
            'actionUrls' => $actionUrls,
        ]);
    }

    /**
     * @param  array<int, array<string, mixed>>  $navigation
     * @return array<int, array<string, mixed>>
     */
    private function resolvedNavigation(string $locale, string $pageKey, array $navigation): array
    {
        return collect($navigation)->map(function (array $item) use ($locale, $pageKey): array {
            $itemPageKey = (string) $item['page_key'];
            $headerLabel = (string) ($item['home_label'] ?? $item['label']);
            $label = $pageKey === 'home' ? $headerLabel : (string) $item['label'];

            return [
                ...$item,
                'label' => $label,
                'header_label' => $headerLabel,
                'href' => route((string) config("public_site.page_routes.{$itemPageKey}"), ['locale' => $locale]),
            ];
        })->all();
    }

    /**
     * @param  array<string, mixed>|null  $article
     * @return array<int, array<string, mixed>>
     */
    private function languageOptions(string $currentLocale, string $pageKey, ?array $article): array
    {
        return collect(PublicFixtureRepository::LOCALES)->map(function (string $targetLocale) use ($currentLocale, $pageKey, $article): array {
            $targetSite = $this->fixtures->get($targetLocale, 'site');
            $href = null;

            if ($pageKey === 'news_show') {
                $targetArticle = $article === null ? null : $this->fixtures->findNewsByArticleKey($targetLocale, (string) $article['article_key']);
                if ($targetArticle !== null) {
                    $href = route('public.news.show', ['locale' => $targetLocale, 'slug' => $targetArticle['slug']]);
                }
            } else {
                $href = route((string) config("public_site.page_routes.{$pageKey}"), ['locale' => $targetLocale]);
            }

            return [
                'locale' => $targetLocale,
                'label' => $targetSite['locale']['label'],
                'short_label' => $targetSite['locale']['short_label'],
                'review_label' => $targetSite['locale']['review_label'],
                'is_review' => $targetSite['publication']['translation_status'] !== 'approved',
                'is_current' => $targetLocale === $currentLocale,
                'available' => $href !== null,
                'href' => $href,
            ];
        })->all();
    }

    /**
     * @param  array<string, mixed>|null  $currentArticle
     * @param  array<int, array<string, mixed>>  $languages
     * @return array<int, array{hreflang:string,href:string}>
     */
    private function hreflangAlternates(string $pageKey, ?array $currentArticle, array $languages, string $canonical): array
    {
        if (! config('public_site.indexing', false) || $canonical === '') {
            return [];
        }

        $currentLanguage = collect($languages)->firstWhere('is_current', true);
        if ($currentLanguage === null) {
            return [];
        }

        $currentLocale = (string) $currentLanguage['locale'];
        if (! $this->publication->isPublicationCandidate($currentLocale, $pageKey, $currentArticle)) {
            return [];
        }

        $eligible = collect($languages)->filter(function (array $language) use ($pageKey, $currentArticle): bool {
            if (! $language['available'] || ! is_string($language['href']) || $language['href'] === '') {
                return false;
            }

            $targetArticle = null;
            if ($pageKey === 'news_show' && $currentArticle !== null) {
                $targetArticle = $this->fixtures->findNewsByArticleKey((string) $language['locale'], (string) $currentArticle['article_key']);
            }

            return $this->publication->isPublicationCandidate((string) $language['locale'], $pageKey, $targetArticle);
        })->values();

        if ($eligible->count() < 2) {
            return [];
        }

        $alternates = $eligible->map(fn (array $language): array => [
            'hreflang' => (string) config("public_site.locales.{$language['locale']}.html_lang"),
            'href' => (string) $language['href'],
        ])->all();

        $japanese = $eligible->firstWhere('locale', 'ja');
        if ($japanese !== null) {
            $alternates[] = ['hreflang' => 'x-default', 'href' => (string) $japanese['href']];
        }

        return $alternates;
    }
}
