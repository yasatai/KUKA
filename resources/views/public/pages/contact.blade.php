@extends('public.layouts.app')
@php
    $seo = $site['seo']['contact'];
    $hero = $contact['copy']['hero'];
    $methodIcons = ['line' => 'line', 'phone' => 'phone', 'store' => 'store'];
    $assuranceIcons = ['LOCK' => 'shield', 'FAST' => 'clock', '¥0' => 'payment', 'SHOP' => 'store'];
@endphp
@section('content')
    @include('public.partials.hero')
    <section class="contact-rebuild-section">
        <div class="public-container contact-rebuild-shell">
            <div class="contact-rebuild-form"><div data-contact-wizard></div><noscript><p class="notice-box">{{ $contact['copy']['noscript'] }}</p></noscript></div>
            <aside class="contact-rebuild-aside" aria-label="{{ $contact['copy']['aside_aria'] }}">
                <h2>{{ $contact['copy']['aside_title'] }}</h2>
                <div class="contact-rebuild-methods">
                    @foreach ($contact['methods'] as $method)
                        @if ($method['key'] === 'store')
                            <a href="{{ route('public.company', ['locale' => $locale]) }}#access"><span aria-hidden="true">@include('public.partials.home-dev-icon', ['name' => $methodIcons[$method['key']]])</span><span><strong>{{ $method['title'] }}</strong><small>{{ $method['description'] }}</small><small>{{ $method['detail'] }}</small></span><b aria-hidden="true">→</b></a>
                        @else
                            <button type="button" disabled @if($method['key'] === 'line') aria-label="{{ $site['ui']['line_unavailable_aria'] }}" @endif><span aria-hidden="true">@include('public.partials.home-dev-icon', ['name' => $methodIcons[$method['key']]])</span><span><strong>{{ $method['title'] }}</strong><small>{{ $method['description'] }}</small><small>{{ $method['detail'] }}</small></span><b aria-hidden="true">→</b></button>
                        @endif
                    @endforeach
                </div>
                <section class="contact-rebuild-precheck" aria-labelledby="contact-precheck-title">
                    <h2 id="contact-precheck-title">{{ $contact['copy']['precheck_title'] }}</h2>
                    <ul>@foreach ($contact['precheck'] as $item)<li>{{ $item }}</li>@endforeach</ul>
                    <a href="{{ route('public.items', ['locale' => $locale]) }}">{{ $contact['copy']['precheck_faq'] }} <span aria-hidden="true">→</span></a>
                </section>
            </aside>
        </div>
    </section>
@endsection

@section('page-cta')
    <section class="contact-rebuild-assurance" aria-label="{{ $contact['copy']['assurance_label'] }}"><div class="public-container contact-rebuild-assurance__grid">@foreach ($contact['assurances'] as $assurance)<p><span aria-hidden="true">@include('public.partials.home-dev-icon', ['name' => $assuranceIcons[$assurance['mark']]])</span><strong>{{ $assurance['title'] }}</strong><small>{{ $assurance['description'] }}</small></p>@endforeach</div></section>
@endsection
