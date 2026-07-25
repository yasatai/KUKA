@extends('public.layouts.app')

@php
    $seo = $site['seo']['home'];
    $home = $site['home'];
    $hero = $home['hero'];
    $itemLookup = collect($items['categories'])->keyBy('id');
    $homeItems = collect($home['items']['cards'])->map(function (array $card) use ($itemLookup): ?array {
        $item = $itemLookup->get($card['item_id']);
        return $item === null ? null : [...$item, 'display_label' => $card['label']];
    })->filter()->values()->all();
    $featureImages = [
        'images/pages/hero-prices.png',
        'images/pages/hero-process.png',
        'images/pages/hero-company.png',
        'images/pages/hero-contact.png',
        'images/pages/hero-news.png',
    ];
    $itemImages = [
        'gold' => 'images/pages/hero-prices.png',
        'coins' => 'images/pages/hero-top.png',
        'jewelry' => 'images/pages/hero-contact.png',
        'tableware' => 'images/pages/hero-company.png',
        'scrap' => 'images/pages/hero-items.png',
    ];
    $processIcons = ['store', 'receipt', 'inspect', 'quote', 'identity', 'payment'];
    $reasonIcons = ['visibility', 'expert', 'store', 'line', 'payment'];
@endphp

@section('content')
    <section class="home-visual-hero" aria-labelledby="page-title">
        <img class="home-visual-hero__image" src="{{ asset($hero['image']) }}" alt="{{ $hero['alt'] }}" width="1784" height="882">
        <div class="home-visual-container home-visual-hero__inner">
            <div class="home-visual-hero__content">
                <p class="home-visual-hero__eyebrow">@include('public.partials.visual-copy', ['copy' => $hero['eyebrow']])</p>
                <h1 id="page-title">@include('public.partials.visual-copy', ['copy' => $hero['title']])</h1>
                <p class="home-visual-hero__lead">@include('public.partials.visual-copy', ['copy' => $hero['lead']])</p>

                <div class="home-visual-hero__trust" aria-label="{{ $site['ui']['state_label'] }}">
                    @foreach ($hero['assurances'] as $assurance)
                        @php
                            $assuranceDescription = ($assurance['dynamic_description'] ?? null) === 'prices.meta.updatedAt'
                                ? $prices['meta']['updatedAt']
                                : $assurance['description'];
                        @endphp
                        <div class="home-visual-trust-item">
                            <span class="home-visual-trust-item__icon">@include('public.partials.home-dev-icon', ['name' => $assurance['icon']])</span>
                            <span><strong>{{ $assurance['title'] }}</strong>@if($assuranceDescription !== '')<small>{{ $assuranceDescription }}</small>@endif</span>
                        </div>
                    @endforeach
                </div>

                <div class="home-visual-hero__actions">
                    @foreach ($hero['actions'] as $action)
                        @php
                            $actionHref = $actionUrls[$action['key']] ?? null;
                            $actionClass = in_array($action['key'], ['contact', 'prices'], true) ? 'button--gold' : 'button--outline';
                        @endphp
                        @if ($actionHref !== null)
                            <a class="button {{ $actionClass }}" href="{{ $actionHref }}">
                                <span class="home-visual-action__icon">@include('public.partials.home-dev-icon', ['name' => $action['key'] === 'contact' ? 'contact' : 'line'])</span>
                                <span class="home-visual-action__copy"><strong>{{ $action['label'] }}</strong>@if($action['description'] !== '')<small>{{ $action['description'] }}</small>@endif</span><span class="home-visual-action__arrow" aria-hidden="true">→</span>
                            </a>
                        @else
                            <button type="button" class="button {{ $actionClass }} is-disabled" disabled aria-label="{{ $site['ui']['line_unavailable_aria'] }}">
                                <span class="home-visual-action__icon">@include('public.partials.home-dev-icon', ['name' => $action['key'] === 'contact' ? 'contact' : 'line'])</span>
                                <span class="home-visual-action__copy"><strong>{{ $action['label'] }}</strong>@if($action['description'] !== '')<small>{{ $action['description'] }}</small>@endif</span><span class="home-visual-action__arrow" aria-hidden="true">→</span>
                            </button>
                        @endif
                    @endforeach
                </div>
                <p class="home-visual-hero__note">@include('public.partials.visual-copy', ['copy' => $hero['note']])</p>
            </div>
        </div>
    </section>

    <section class="home-visual-section home-visual-prices" aria-labelledby="home-prices-title">
        <div class="home-visual-container">
            <header class="home-visual-heading home-visual-heading--prices">
                @if($home['prices']['eyebrow'] !== '')<span class="home-visual-kicker">{{ $home['prices']['eyebrow'] }}</span>@endif
                <h2 id="home-prices-title">@include('public.partials.visual-copy', ['copy' => $home['prices']['title']])</h2>
            </header>
            <div class="home-visual-prices-subhead">
                <p class="home-visual-updated">{{ $prices['copy']['updated'] }}：{{ $prices['meta']['updatedAt'] }}</p>
                <p class="home-visual-prices-lead">{{ $home['prices']['lead']['text'] }}</p>
            </div>
            <div class="home-visual-prices__layout">
                <div class="home-visual-intro home-visual-intro--prices">
                    <a class="home-visual-outline-link" href="{{ route('public.prices', ['locale' => $locale]) }}">{{ $home['prices']['link'] }} <span aria-hidden="true">→</span></a>
                </div>
                <div class="home-visual-price-grid">
                    @foreach ($prices['metals'] as $metal)
                        @php
                            $homeGrade = collect($metal['grades'])->where('is_active', true)->sortBy('sort_order')->first();
                            $homeTrend = collect($metal['trend'])->values();
                            $homeTrendMin = (float) $homeTrend->min();
                            $homeTrendRange = max(1, (float) $homeTrend->max() - $homeTrendMin);
                            $homeTrendLastIndex = max(1, $homeTrend->count() - 1);
                            $homeTrendPoints = $homeTrend->map(fn ($value, $index) => sprintf('%.2f,%.2f', ($index / $homeTrendLastIndex) * 100, 37 - ((((float) $value - $homeTrendMin) / $homeTrendRange) * 31)))->implode(' ');
                        @endphp
                        <article class="home-visual-price-card" style="--metal-accent: {{ $metal['accent'] }}">
                            <div class="home-visual-price-card__head">
                                <span class="home-visual-price-card__mark" aria-hidden="true">@include('public.partials.home-dev-icon', ['name' => 'ingot'])</span>
                                <h3>{{ $metal['name'] }}</h3>
                                <small>{{ $metal['englishName'] }}</small>
                            </div>
                            <p class="home-visual-price-card__grade">{{ $homeGrade['display_name'] ?? '—' }}</p>
                            <p class="home-visual-price-card__value">{{ number_format($metal['representative']) }}<small>{{ $metal['unit'] }}</small></p>
                            <p class="change {{ $metal['change'] >= 0 ? 'change--up' : 'change--down' }}">{{ $site['ui']['common']['change'] }} {{ $metal['change'] >= 0 ? '+' : '' }}{{ number_format($metal['change']) }}</p>
                            <div class="home-visual-price-card__spark" aria-hidden="true">
                                <svg viewBox="0 0 100 40" preserveAspectRatio="none" focusable="false">
                                    <polygon points="0,40 {{ $homeTrendPoints }} 100,40"></polygon>
                                    <polyline points="{{ $homeTrendPoints }}"></polyline>
                                </svg>
                            </div>
                            <a href="{{ route('public.prices', ['locale' => $locale]) }}">{{ $home['prices']['card_link'] }} <span aria-hidden="true">→</span></a>
                        </article>
                    @endforeach
                </div>
            </div>
            <p class="home-visual-price-note">@include('public.partials.visual-copy', ['copy' => $home['prices']['note']])</p>
        </div>
    </section>

    <section class="home-visual-section home-visual-reasons" aria-labelledby="home-reason-title">
        <div class="home-visual-container">
            <header class="home-visual-heading">
                @if($home['reasons']['eyebrow'] !== '')<span class="home-visual-kicker">{{ $home['reasons']['eyebrow'] }}</span>@endif
                <h2 id="home-reason-title">@include('public.partials.visual-copy', ['copy' => $home['reasons']['title']])</h2>
            </header>
            <div class="home-visual-reason-grid">
                @foreach ($home['reasons']['items'] as $reason)
                    <article class="home-visual-reason-card">
                        <div class="home-visual-reason-card__copy">
                            <span class="home-visual-reason-card__icon" aria-hidden="true">@include('public.partials.home-dev-icon', ['name' => $reasonIcons[$loop->index]])</span>
                            <div><h3>{{ $reason['title'] }}</h3>
                            <p>@include('public.partials.visual-copy', ['copy' => $reason['description']])</p></div>
                        </div>
                        <img src="{{ asset($featureImages[$loop->index]) }}" alt="" width="1672" height="941" loading="lazy">
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="home-visual-section home-visual-process" aria-labelledby="home-process-title">
        <div class="home-visual-container">
            <header class="home-visual-heading">
                @if($home['process']['eyebrow'] !== '')<span class="home-visual-kicker">{{ $home['process']['eyebrow'] }}</span>@endif
                <h2 id="home-process-title">@include('public.partials.visual-copy', ['copy' => $home['process']['title']])</h2>
            </header>
            <div class="home-visual-process-grid">
                @foreach ($home['process']['steps'] as $step)
                    <article class="home-visual-process-card">
                        <span class="home-visual-process-card__number">{{ $step['number'] }}</span>
                        <span class="home-visual-process-card__icon" aria-hidden="true">@include('public.partials.home-dev-icon', ['name' => $processIcons[$loop->index]])</span>
                        <div><h3>{{ $step['title'] }}</h3><p>@include('public.partials.visual-copy', ['copy' => $step['description']])</p></div>
                    </article>
                @endforeach
            </div>
            <p class="home-visual-section-link"><a href="{{ route('public.process', ['locale' => $locale]) }}">{{ $home['process']['link'] }} <span aria-hidden="true">→</span></a></p>
        </div>
    </section>

    <section class="home-visual-section home-visual-items" aria-labelledby="home-items-title">
        <div class="home-visual-container home-visual-items__layout">
            <header class="home-visual-intro home-visual-intro--items">
                @if($home['items']['eyebrow'] !== '')<span class="home-visual-kicker">{{ $home['items']['eyebrow'] }}</span>@endif
                <h2 id="home-items-title">@include('public.partials.visual-copy', ['copy' => $home['items']['title']])</h2>
                <p>@include('public.partials.visual-copy', ['copy' => $home['items']['lead']])</p>
                <a class="home-visual-outline-link" href="{{ route('public.items', ['locale' => $locale]) }}">{{ $home['items']['link'] }} <span aria-hidden="true">→</span></a>
            </header>
            <div class="home-visual-item-grid">
                @foreach ($homeItems as $item)
                    <article class="home-visual-item-card">
                        <img src="{{ asset($itemImages[$item['id']]) }}" alt="" width="1672" height="941" loading="lazy">
                        <h3>{{ $item['display_label'] }}</h3>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="home-visual-section home-visual-information">
        <div class="home-visual-container home-visual-information__layout">
            <article class="home-visual-store">
                <div class="home-visual-store__copy">
                    @if($home['store']['eyebrow'] !== '')<span class="home-visual-kicker">{{ $home['store']['eyebrow'] }}</span>@endif
                    <h2>@include('public.partials.visual-copy', ['copy' => $home['store']['title']])</h2>
                    <p>@include('public.partials.visual-copy', ['copy' => $home['store']['lead']])</p>
                    <a class="home-visual-outline-link" href="{{ route('public.company', ['locale' => $locale]) }}#access">{{ $home['store']['link'] }} <span aria-hidden="true">→</span></a>
                </div>
                <img src="{{ asset($company['copy']['hero']['image']) }}" alt="{{ $company['copy']['hero']['alt'] }}" width="1672" height="941" loading="lazy">
            </article>
            <article class="home-visual-news">
                <header>
                    <div>@if($home['news']['eyebrow'] !== '')<span class="home-visual-kicker">{{ $home['news']['eyebrow'] }}</span>@endif<h2>@include('public.partials.visual-copy', ['copy' => $home['news']['title']])</h2></div>
                    <a href="{{ route('public.news', ['locale' => $locale]) }}">{{ $home['news']['link'] }} <span aria-hidden="true">→</span></a>
                </header>
                <div class="home-visual-news__list">
                    @foreach (array_slice($news['items'], 0, 3) as $newsArticle)
                        <a href="{{ route('public.news.show', ['locale' => $locale, 'slug' => $newsArticle['slug']]) }}"><time datetime="{{ $newsArticle['date'] }}">{{ str_replace('-', '.', $newsArticle['date']) }}</time><span>{{ $newsArticle['category'] }}</span><strong>{{ $newsArticle['title'] }}</strong></a>
                    @endforeach
                </div>
            </article>
        </div>
    </section>
@endsection
