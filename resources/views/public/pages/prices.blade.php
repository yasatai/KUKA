@extends('public.layouts.app')
@php
    $seo = $site['seo']['prices'];
    $hero = $prices['copy']['hero'];
    $relatedRoutes = [
        'items' => 'public.items',
        'process' => 'public.process',
        'company' => 'public.company',
    ];
@endphp

@section('content')
    <section class="prices-intro" aria-labelledby="prices-title">
        <div class="public-container prices-intro__inner">
            <div class="prices-intro__copy">
                <p class="prices-intro__updated"><span aria-hidden="true">◷</span>{{ $prices['copy']['actions']['updated'] }}：{{ $prices['meta']['updatedAt'] }}</p>
                <h1 id="prices-title">{{ $prices['copy']['hero']['title'] }}</h1>
                <p>{{ $prices['copy']['hero']['lead'] }}</p>
                <div class="prices-intro__ctas">
                    <button class="prices-consult-button prices-consult-button--line" type="button" disabled aria-label="{{ $site['ui']['line_unavailable_aria'] }}">
                        <span class="prices-consult-button__icon" aria-hidden="true">LINE</span>
                        <span><strong>{{ $prices['copy']['actions']['line'] }}</strong><small>{{ $prices['copy']['actions']['line_description'] }}</small></span>
                        <span aria-hidden="true">→</span>
                    </button>
                    <a class="prices-consult-button prices-consult-button--contact" href="{{ route('public.contact', ['locale' => $locale]) }}">
                        <span class="prices-consult-button__icon" aria-hidden="true">▣</span>
                        <span><strong>{{ $prices['copy']['actions']['contact'] }}</strong><small>{{ $prices['copy']['actions']['contact_description'] }}</small></span>
                        <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
            <div class="prices-intro__media"><img src="{{ asset($prices['copy']['hero']['image']) }}" alt="{{ $prices['copy']['hero']['alt'] }}"></div>
            <div data-price-actions class="prices-intro__actions">
                <div class="prices-actions-island prices-actions-island--fallback">
                    <div class="prices-document-actions">
                        <button type="button" class="prices-document-button" onclick="window.print()"><span aria-hidden="true">▣</span>{{ $prices['copy']['actions']['print'] }}</button>
                        <button type="button" class="prices-document-button" title="{{ $prices['copy']['actions']['pdf_title'] }}"><span aria-hidden="true">PDF</span>{{ $prices['copy']['actions']['pdf'] }}</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="prices-market" aria-label="{{ $prices['copy']['cards']['group_label'] }}">
        <div class="public-container" data-price-explorer>
            <div class="prices-fallback">
                @include('public.partials.price-cards')
                <p class="prices-market-disclaimer">{{ $prices['meta']['disclaimer'] }}</p>
                <div class="prices-grade-grid">
                    @foreach ($prices['metals'] as $metal)
                        <section class="prices-grade-panel" aria-labelledby="prices-fallback-grade-{{ $metal['id'] }}">
                            <h2 id="prices-fallback-grade-{{ $metal['id'] }}"><span aria-hidden="true">{{ $metal['symbol'] }}</span>{{ str_replace('{metal}', $metal['name'], $prices['copy']['table']['heading']) }}<small>({{ $metal['unit'] }})</small></h2>
                            <div class="prices-grade-table-wrap">
                                <table class="prices-grade-table">
                                    <caption class="sr-only">{{ str_replace('{metal}', $metal['name'], $prices['copy']['table']['caption']) }}</caption>
                                    <thead><tr><th scope="col">{{ $prices['copy']['table']['grade'] }}</th><th scope="col">{{ $prices['copy']['table']['reference_price'] }}</th><th scope="col">{{ $prices['copy']['table']['change'] }}</th><th scope="col">{{ $prices['copy']['table']['note'] }}</th></tr></thead>
                                    <tbody>
                                        @foreach (collect($metal['grades'])->where('is_active', true)->sortBy('sort_order') as $grade)
                                            <tr><th scope="row">{{ $grade['code'] }}@if ($grade['display_name'] !== $grade['code'])<small> ({{ $grade['display_name'] }})</small>@endif</th><td>{{ $grade['price'] === null ? $prices['copy']['table']['unavailable'] : number_format($grade['price']) }}</td><td>{{ $grade['previous_change'] === null ? $prices['copy']['table']['unavailable'] : (($grade['previous_change'] >= 0 ? '+' : '').number_format($grade['previous_change'])) }}</td><td>{{ $grade['note'] !== '' ? $grade['note'] : $prices['copy']['table']['unavailable'] }}</td></tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    @endforeach
                </div>
            </div>
        </div>
        <noscript><p class="public-container prices-noscript">{{ $prices['copy']['noscript'] }}</p></noscript>
    </section>

    <section class="prices-notes" aria-labelledby="prices-notes-title">
        <div class="public-container prices-notes__inner">
            <h2 id="prices-notes-title"><span aria-hidden="true">!</span>{{ $prices['copy']['notes']['title'] }}</h2>
            <ul>@foreach ($prices['notes'] as $note)<li>{{ $note }}</li>@endforeach</ul>
        </div>
    </section>

    <section class="prices-related" aria-labelledby="prices-related-title">
        <div class="public-container">
            <h2 id="prices-related-title">{{ $prices['copy']['related']['title'] }}</h2>
            <div class="prices-related__grid">
                @foreach ($prices['copy']['related']['items'] as $item)
                    <a class="prices-related-card" href="{{ route($relatedRoutes[$item['route']], ['locale' => $locale]) }}">
                        <img src="{{ asset($item['image']) }}" alt="{{ $item['alt'] }}">
                        <span><strong>{{ $item['title'] }}</strong><small>{{ $item['description'] }}</small></span>
                        <span class="prices-related-card__arrow" aria-hidden="true">→</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('page-cta')
    @include('public.partials.prices-cta')
@endsection
