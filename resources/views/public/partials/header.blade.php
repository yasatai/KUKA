@php
    $headerLineAction = collect($site['home']['hero']['actions'])->firstWhere('key', 'line');
    $headerContactAction = collect($site['home']['hero']['actions'])->firstWhere('key', 'contact');
    $headerCurrentLanguage = collect($languageOptions)->firstWhere('is_current', true);
    $activeNavigationPageKey = $pageKey === 'news_show' ? 'news' : $pageKey;
@endphp

<div class="site-utility home-top-utility" aria-label="{{ $site['ui']['state_label'] }}">
    <div class="home-top-utility__inner">
        <p>{{ $site['home']['utility']['text'] }}</p>
        <div class="site-utility__right home-top-utility__right">
            <details class="home-top-language">
                <summary>{{ $headerCurrentLanguage['short_label'] ?? $site['locale']['short_label'] }}</summary>
                <nav class="language-nav language-nav--utility" aria-label="{{ $site['ui']['language_navigation'] }}">
                    @foreach ($languageOptions as $language)
                        @if ($language['available'])
                            <a data-language-option="{{ $language['locale'] }}" data-available="true" href="{{ $language['href'] }}" hreflang="{{ config("public_site.locales.{$language['locale']}.html_lang") }}" lang="{{ config("public_site.locales.{$language['locale']}.html_lang") }}" @if($language['is_current']) aria-current="page" @endif>
                                {{ $language['short_label'] }}@if($language['is_review'])<small>{{ $language['review_label'] }}</small>@endif
                            </a>
                        @else
                            <span data-language-option="{{ $language['locale'] }}" data-available="false" aria-disabled="true" title="{{ $site['ui']['translation_unavailable'] }}">{{ $language['short_label'] }}<small>{{ $site['ui']['translation_unavailable'] }}</small></span>
                        @endif
                    @endforeach
                </nav>
            </details>
            <button type="button" class="home-top-utility__action home-top-utility__action--line" disabled aria-label="{{ $site['ui']['line_unavailable_aria'] }}">
                @include('public.partials.home-dev-icon', ['name' => 'line'])
                <span>{{ $headerLineAction['label'] ?? $site['ui']['line_unavailable'] }}</span>
            </button>
            <a class="home-top-utility__action home-top-utility__action--contact" href="{{ route('public.contact', ['locale' => $locale]) }}">
                @include('public.partials.home-dev-icon', ['name' => 'contact'])
                <span>{{ $headerContactAction['label'] ?? $site['ui']['contact'] }}</span>
            </a>
        </div>
    </div>
</div>

<header class="site-header" data-public-header>
    <div class="public-container site-header__inner">
        <a class="site-brand home-top-brand" href="{{ route('public.home', ['locale' => $locale]) }}" aria-label="{{ $site['brand']['name'] }} {{ $site['ui']['home'] }}">
            <span class="home-top-brand__image-frame" aria-hidden="true">
                <img src="{{ asset('images/brand/kuka-logo.png') }}" alt="" width="1536" height="1024">
            </span>
        </a>
        <nav class="desktop-nav" aria-label="{{ $site['ui']['main_navigation'] }}">
            @foreach ($site['navigation'] as $item)
                <a href="{{ $item['href'] }}" data-page-key="{{ $item['page_key'] }}" @if($activeNavigationPageKey === $item['page_key']) aria-current="page" @endif class="{{ $item['page_key'] === 'contact' ? 'nav-contact' : '' }}">{{ $item['header_label'] ?? $item['label'] }}</a>
            @endforeach
        </nav>
        <div class="mobile-language-switch" aria-hidden="true">{{ $site['locale']['short_label'] }}</div>
        <div class="mobile-nav-island" data-mobile-nav-root></div>
    </div>
</header>
