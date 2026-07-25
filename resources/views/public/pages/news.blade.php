@extends('public.layouts.app')
@php $seo = $site['seo']['news']; $hero = $news['copy']['hero']; @endphp
@section('content')
    @include('public.partials.hero')
    <section class="news-rebuild-section"><div class="public-container"><div data-news-explorer></div><noscript><h2>{{ $news['copy']['list_title'] }}</h2><div class="news-rebuild-list">@foreach ($news['items'] as $newsArticle)@php($newsCategoryLabel = collect($news['categories'])->firstWhere('code', $newsArticle['category_code'])['label'] ?? $newsArticle['category'])<a class="news-rebuild-row" href="{{ route('public.news.show', ['locale' => $locale, 'slug' => $newsArticle['slug']]) }}"><time datetime="{{ $newsArticle['date'] }}">{{ str_replace('-', '.', $newsArticle['date']) }}</time><span class="news-rebuild-row__category">{{ $newsCategoryLabel }}</span><span class="news-rebuild-row__title">{{ $newsArticle['title'] }}</span><span aria-hidden="true">→</span></a>@endforeach</div></noscript></div></section>
@endsection

@section('page-cta')
    <section class="news-rebuild-cta" aria-labelledby="news-cta-title"><img src="{{ asset($news['copy']['cta']['image']) }}" alt="" width="1792" height="1024"><div class="public-container news-rebuild-cta__inner"><div><h2 id="news-cta-title">{{ $news['copy']['cta']['title'] }}</h2><p>{{ $news['copy']['cta']['lead'] }}</p></div><div><button type="button" class="button button--line" disabled aria-label="{{ $site['ui']['line_unavailable_aria'] }}">{{ $news['copy']['cta']['line'] }}</button><a class="button button--gold" href="{{ route('public.contact', ['locale' => $locale]) }}">{{ $news['copy']['cta']['contact'] }}</a></div></div></section>
@endsection
