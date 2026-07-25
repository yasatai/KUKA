@extends('public.layouts.app')
@php
    $seo = ['title' => $article['title'].'｜KUKA', 'description' => $article['excerpt']];
    $hero = [...$news['copy']['hero'], 'eyebrow' => $news['copy']['detail_eyebrow'], 'title' => $article['title'], 'lead' => $article['excerpt']];
    $articleCategory = collect($news['categories'])->firstWhere('code', $article['category_code'])['label'] ?? $article['category'];
@endphp
@section('content')
    @include('public.partials.hero')
    <article class="news-detail-rebuild"><div class="public-container news-detail-rebuild__inner"><div class="news-detail-rebuild__meta"><time datetime="{{ $article['date'] }}">{{ str_replace('-', '.', $article['date']) }}</time><span>{{ $articleCategory }}</span>@if($article['important'])<span class="news-rebuild-row__important">{{ $site['ui']['common']['important'] }}</span>@endif</div><span class="fixture-badge">{{ $news['copy']['development_article'] }}</span><div class="news-detail-rebuild__body">@foreach ($article['body'] as $paragraph)<p>{{ $paragraph }}</p>@endforeach</div><p><a class="text-link" href="{{ route('public.news', ['locale' => $locale]) }}">{{ $news['copy']['back'] }}</a></p></div></article>
@endsection

@section('page-cta')
    <section class="news-rebuild-cta" aria-labelledby="news-detail-cta-title"><div class="public-container news-rebuild-cta__inner"><div><h2 id="news-detail-cta-title">{{ $news['copy']['cta']['title'] }}</h2><p>{{ $news['copy']['cta']['lead'] }}</p></div><div><button type="button" class="button button--line" disabled aria-label="{{ $site['ui']['line_unavailable_aria'] }}">{{ $news['copy']['cta']['line'] }}</button><a class="button button--gold" href="{{ route('public.contact', ['locale' => $locale]) }}">{{ $news['copy']['cta']['contact'] }}</a></div></div></section>
@endsection
