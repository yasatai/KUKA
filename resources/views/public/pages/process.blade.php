@extends('public.layouts.app')
@php
    $seo = $site['seo']['process'];
    $hero = $process['copy']['hero'];
    $assuranceIcons = ['¥0' => 'payment', 'DAY' => 'clock', 'ID' => 'identity', 'LOCK' => 'shield', 'PRO' => 'expert'];
    $stepIcons = ['store', 'receipt', 'inspect', 'quote', 'identity', 'payment'];
@endphp

@section('content')
    @include('public.partials.hero')

    <section class="process-rebuild-assurance" aria-label="{{ $process['copy']['assurance_label'] }}">
        <div class="public-container process-rebuild-assurance__grid">
            @foreach ($process['assurances'] as $assurance)
                <p><span aria-hidden="true">@include('public.partials.home-dev-icon', ['name' => $assuranceIcons[$assurance['mark']]])</span><strong>{{ $assurance['title'] }}</strong><small>{{ $assurance['description'] }}</small></p>
            @endforeach
        </div>
    </section>

    <section class="process-rebuild-steps" aria-labelledby="process-steps-title">
        <div class="public-container">
            <header class="process-rebuild-heading"><span></span><h2 id="process-steps-title">{{ $process['copy']['steps_title'] }}</h2><span></span></header>
            <div class="process-rebuild-grid">
                @foreach ($process['steps'] as $step)
                    <article class="process-rebuild-step">
                        <span class="process-rebuild-step__number">{{ $step['number'] }}</span>
                        <span class="process-rebuild-step__icon" aria-hidden="true">@include('public.partials.home-dev-icon', ['name' => $stepIcons[$loop->index]])</span>
                        <h3>{{ $step['title'] }}</h3>
                        <img src="{{ asset($step['image']) }}" alt="{{ $step['alt'] }}" width="1792" height="1024">
                        <p>{{ $step['description'] }}</p>
                        <div class="process-rebuild-step__point"><strong>{{ $process['copy']['point'] }}</strong><span>{{ $step['point'] }}</span></div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="process-rebuild-information">
        <div class="public-container process-rebuild-information__grid">
            <article class="process-rebuild-panel" aria-labelledby="process-documents-title">
                <h2 id="process-documents-title">{{ $process['copy']['documents_title'] }}</h2>
                <p>{{ $process['copy']['documents_lead'] }}</p>
                <ul>@foreach ($process['documents'] as $document)<li><strong>{{ $document['title'] }}</strong><span>{{ $document['description'] }}</span></li>@endforeach</ul>
            </article>
            <article class="process-rebuild-panel process-rebuild-panel--notes" aria-labelledby="process-notes-title">
                <h2 id="process-notes-title">{{ $process['copy']['notes_title'] }}</h2>
                <ul>@foreach ($process['notes'] as $note)<li>{{ $note }}</li>@endforeach</ul>
                <span class="process-rebuild-panel__mark" aria-hidden="true">✓</span>
            </article>
        </div>
    </section>

    <section class="process-rebuild-unavailable" aria-labelledby="process-unavailable-title">
        <div class="public-container process-rebuild-unavailable__inner">
            <h2 id="process-unavailable-title"><span aria-hidden="true">×</span>{{ $process['copy']['unavailable_title'] }}</h2>
            <ul>@foreach ($process['unavailable'] as $entry)<li>{{ $entry }}</li>@endforeach</ul>
            <p>{{ $process['copy']['unavailable_note'] }}</p>
        </div>
    </section>
@endsection

@section('page-cta')
    <section class="process-rebuild-cta" aria-labelledby="process-cta-title">
        <img src="{{ asset($process['copy']['cta']['image']) }}" alt="" width="1792" height="1024">
        <div class="public-container process-rebuild-cta__inner">
            <div><h2 id="process-cta-title">{{ $process['copy']['cta']['title'] }}</h2><p>{{ $process['copy']['cta']['lead'] }}</p></div>
            <div class="process-rebuild-cta__actions">
                <button type="button" class="button button--line" disabled aria-label="{{ $site['ui']['line_unavailable_aria'] }}">{{ $process['copy']['cta']['line'] }}</button>
                <a class="button button--gold" href="{{ route('public.contact', ['locale' => $locale]) }}">{{ $process['copy']['cta']['contact'] }}</a>
            </div>
        </div>
    </section>
@endsection
