@extends('public.layouts.app')
@php
    $seo = $site['seo']['company'];
    $hero = $company['copy']['hero'];
    $assuranceIcons = ['CLEAR' => 'visibility', 'SHOP' => 'store', 'PAY' => 'payment', 'LOCK' => 'shield', 'PRO' => 'expert'];
    $licenseIcons = ['PERMIT' => 'certificate', 'GROUP' => 'team', 'LAW' => 'scales'];
@endphp

@section('content')
    @include('public.partials.hero')

    <section class="company-rebuild-assurance" aria-label="{{ $company['copy']['assurance_label'] }}">
        <div class="public-container company-rebuild-assurance__grid">
            @foreach ($company['assurances'] as $assurance)
                <p><span aria-hidden="true">@include('public.partials.home-dev-icon', ['name' => $assuranceIcons[$assurance['mark']]])</span><strong>{{ $assurance['title'] }}</strong><small>{{ $assurance['description'] }}</small></p>
            @endforeach
        </div>
    </section>

    <section class="company-rebuild-overview" aria-labelledby="company-profile-title">
        <div class="public-container company-rebuild-overview__grid">
            <article>
                <header class="company-rebuild-title"><h2 id="company-profile-title">{{ $company['copy']['profile_title'] }}</h2><span></span></header>
                <dl class="company-rebuild-profile">
                    @foreach ($company['profile'] as $row)<div><dt>{{ $row['label'] }}</dt><dd>{{ $row['value'] }}</dd></div>@endforeach
                </dl>
                <p class="company-rebuild-notice company-rebuild-notice--after">{{ $company['meta']['notice'] }}</p>
            </article>
            <article id="access">
                <header class="company-rebuild-title"><h2>{{ $company['copy']['access_title'] }}</h2><span></span></header>
                <div class="company-rebuild-access__media">
                    <img src="{{ asset($company['store']['image']) }}" alt="{{ $company['store']['alt'] }}" width="1792" height="1024">
                    <div class="company-rebuild-map" role="img" aria-label="{{ $company['copy']['map_aria'] }}"><strong>{{ $company['copy']['map_title'] }}</strong><span>{{ $company['copy']['map_text'] }}</span></div>
                </div>
                <dl class="company-rebuild-access__list">
                    <div><dt>{{ $company['copy']['store_label'] }}</dt><dd>{{ $company['store']['name'] }}</dd></div>
                    <div><dt>{{ $company['copy']['address_label'] }}</dt><dd>{{ $company['store']['address'] }}</dd></div>
                    <div><dt>{{ $company['copy']['access_label'] }}</dt><dd>{{ $company['store']['access'] }}</dd></div>
                </dl>
            </article>
        </div>
    </section>

    <section class="company-rebuild-store" aria-labelledby="company-store-title">
        <div class="public-container">
            <header class="company-rebuild-title"><h2 id="company-store-title">{{ $company['copy']['features_title'] }}</h2><span></span></header>
            <div class="company-rebuild-store__grid">
                @foreach ($company['features'] as $feature)
                    <article><img src="{{ asset($feature['image']) }}" alt="{{ $feature['alt'] }}" width="1792" height="1024"><div><h3>{{ $feature['title'] }}</h3><p>{{ $feature['description'] }}</p></div></article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="company-rebuild-licenses" aria-labelledby="company-licenses-title">
        <div class="public-container">
            <header class="company-rebuild-title"><h2 id="company-licenses-title">{{ $company['copy']['licenses_title'] }}</h2><span></span></header>
            <p class="company-rebuild-notice">{{ $company['copy']['licenses_lead'] }}</p>
            <div class="company-rebuild-licenses__grid">
                @foreach ($company['licenses'] as $license)
                    <article><span aria-hidden="true">@include('public.partials.home-dev-icon', ['name' => $licenseIcons[$license['mark']]])</span><div><h3>{{ $license['label'] }}</h3><p>{{ $license['value'] }}</p></div></article>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('page-cta')
    <section class="company-rebuild-cta" aria-labelledby="company-cta-title">
        <img src="{{ asset($company['copy']['cta']['image']) }}" alt="" width="1792" height="1024">
        <div class="public-container company-rebuild-cta__inner">
            <div><h2 id="company-cta-title">{{ $company['copy']['cta']['title'] }}</h2><p>{{ $company['copy']['cta']['lead'] }}</p></div>
            <div class="company-rebuild-cta__actions">
                <button type="button" class="button button--line" disabled aria-label="{{ $site['ui']['line_unavailable_aria'] }}">{{ $company['copy']['cta']['line'] }}</button>
                <a class="button button--gold" href="{{ route('public.contact', ['locale' => $locale]) }}">{{ $company['copy']['cta']['contact'] }}</a>
            </div>
            <div class="company-rebuild-cta__pending"><strong>{{ $company['copy']['cta']['pending_label'] }}</strong><span>{{ $company['copy']['cta']['pending_value'] }}</span></div>
        </div>
    </section>
@endsection
