@extends('public.layouts.app')
@php
    $seo = $site['seo']['items'];
    $hero = $items['copy']['hero'];
    $assuranceIcons = ['¥0' => 'gift', 'UP' => 'chart', 'DAY' => 'clock', 'MIX' => 'scrap'];
    $categoryIcons = ['gold' => 'ingot', 'coins' => 'coin', 'jewelry' => 'jewelry', 'silver' => 'tableware', 'platinum' => 'jewelry', 'palladium' => 'jewelry', 'scrap' => 'scrap', 'tableware' => 'scrap'];
    $bottomIcons = ['¥0' => 'gift', 'DAY' => 'clock', 'INFO' => 'visibility', 'LOCK' => 'shield'];
@endphp

@section('content')
    @include('public.partials.hero')

    <section class="items-rebuild-assurance" aria-label="{{ $items['copy']['assurance_label'] }}">
        <div class="public-container items-rebuild-assurance__grid">
            @foreach ($items['assurances'] as $assurance)
                <article class="items-rebuild-assurance__item">
                    <span class="items-rebuild-assurance__icon" aria-hidden="true">@include('public.partials.home-dev-icon', ['name' => $assuranceIcons[$assurance['mark']]])</span>
                    <p><strong>{{ $assurance['title'] }}</strong><span>{{ $assurance['description'] }}</span></p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="items-rebuild-categories" aria-labelledby="items-category-title">
        <div class="public-container">
            <header class="items-rebuild-heading">
                <span aria-hidden="true"></span>
                <h2 id="items-category-title">{{ $items['copy']['categories_title'] }}</h2>
                <span aria-hidden="true"></span>
                <p>{{ $items['copy']['categories_lead'] }}</p>
            </header>
            <div class="items-rebuild-grid">
                @foreach ($items['categories'] as $item)
                    <article class="items-rebuild-card">
                        <img src="{{ asset($item['image']) }}" alt="{{ $item['alt'] }}" width="1792" height="1024">
                        <div class="items-rebuild-card__body">
                            <h3><span aria-hidden="true">@include('public.partials.home-dev-icon', ['name' => $categoryIcons[$item['id']]])</span>{{ $item['name'] }}</h3>
                            <p>{{ $item['description'] }}</p>
                            <strong class="items-rebuild-card__note">{{ $item['note'] }}</strong>
                            <span class="items-rebuild-card__detail">{{ $items['copy']['detail_label'] }} <span aria-hidden="true">→</span></span>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="items-rebuild-unavailable" aria-labelledby="items-unavailable-title">
        <div class="public-container items-rebuild-unavailable__inner">
            <h2 id="items-unavailable-title"><span aria-hidden="true">×</span>{{ $items['copy']['unavailable_title'] }}</h2>
            <div>
                <ul>@foreach ($items['unavailable'] as $entry)<li>{{ $entry }}</li>@endforeach</ul>
                <p>{{ $items['copy']['review_title'] }}：{{ implode('、', $items['needsReview']) }}</p>
            </div>
        </div>
    </section>

    <section class="items-rebuild-faq" aria-labelledby="items-faq-title">
        <div class="public-container items-rebuild-faq__grid">
            <div>
                <h2 id="items-faq-title">{{ $items['copy']['faq_title'] }}</h2>
                <div class="items-rebuild-faq__list">
                    @foreach ($items['faq'] as $faq)
                        <details>
                            <summary><span>Q.</span>{{ $faq['question'] }}</summary>
                            <p>{{ $faq['answer'] }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
            <aside class="items-rebuild-consultation" aria-labelledby="items-consultation-title">
                <h2 id="items-consultation-title">{{ $items['copy']['cta']['title'] }}</h2>
                <p>{{ $items['copy']['cta']['lead'] }}</p>
                <div class="items-rebuild-consultation__actions">
                    <button type="button" class="button button--line" disabled aria-label="{{ $site['ui']['line_unavailable_aria'] }}">{{ $items['copy']['cta']['line'] }}</button>
                    <a class="button button--gold" href="{{ route('public.contact', ['locale' => $locale]) }}">{{ $items['copy']['cta']['contact'] }}</a>
                </div>
                <p class="items-rebuild-consultation__pending">{{ $items['copy']['cta']['pending'] }}</p>
            </aside>
        </div>
    </section>
@endsection

@section('page-cta')
    <section class="items-rebuild-bottom" aria-labelledby="items-bottom-title">
        <div class="public-container">
            <h2 id="items-bottom-title">{{ $items['copy']['bottom_title'] }}</h2>
            <div class="items-rebuild-bottom__grid">
                @foreach ($items['bottomAssurances'] as $assurance)
                    <p><span aria-hidden="true">@include('public.partials.home-dev-icon', ['name' => $bottomIcons[$assurance['mark']]])</span><strong>{{ $assurance['title'] }}</strong><small>{{ $assurance['description'] }}</small></p>
                @endforeach
            </div>
        </div>
    </section>
@endsection
