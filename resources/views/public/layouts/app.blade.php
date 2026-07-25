<!DOCTYPE html>
<html lang="{{ config("public_site.locales.{$locale}.html_lang") }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="{{ $robots }}">
    <meta name="description" content="{{ $seo['description'] }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="{{ config("public_site.locales.{$locale}.og_locale") }}">
    <meta property="og:site_name" content="{{ $site['brand']['name'] }}">
    <meta property="og:title" content="{{ $seo['title'] }}">
    <meta property="og:description" content="{{ $seo['description'] }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{{ asset($hero['image']) }}">
    <link rel="canonical" href="{{ $canonical }}">
    @foreach ($hreflangAlternates as $alternate)
        <link rel="alternate" hreflang="{{ $alternate['hreflang'] }}" href="{{ $alternate['href'] }}">
    @endforeach
    <title>{{ $seo['title'] }}</title>
    <script>window.__KUKA_PUBLIC_PAGE__ = {{ Illuminate\Support\Js::from($publicPayload) }};</script>
    @vite('resources/js/public.tsx')
</head>
<body data-page="{{ $pageKey === 'news_show' ? 'news-detail' : $pageKey }}" data-locale="{{ $locale }}">
    <a class="skip-link" href="#main-content">{{ $site['ui']['skip_link'] }}</a>
    @if ($site['meta']['review_banner'] !== '')
        <p class="translation-review-banner" role="status">{{ $site['meta']['review_banner'] }}</p>
    @endif
    <p class="dev-notice" role="note">{{ $site['meta']['notice'] }}</p>
    @include('public.partials.header')

    <main id="main-content" class="page-main" tabindex="-1">
        @yield('content')
    </main>

    @hasSection('page-cta')
        @yield('page-cta')
    @else
        @include('public.partials.cta')
    @endif

    @include('public.partials.footer')

    <nav class="sp-fixed-cta" aria-label="{{ $site['ui']['mobile_fixed_navigation'] }}">
        <button type="button" class="is-disabled" disabled aria-label="{{ $site['ui']['line_unavailable_aria'] }}">{!! nl2br(e($site['ui']['line_unavailable'])) !!}</button>
        <a href="{{ route('public.company', ['locale' => $locale]) }}#access">{{ $site['ui']['access'] }}</a>
        <a href="{{ route('public.contact', ['locale' => $locale]) }}">{{ $site['ui']['contact'] }}</a>
    </nav>
</body>
</html>
