@if ($pageKey === 'home')
    @php
        $homeCta = $site['home']['final_cta'];
    @endphp
    <section class="cta-band" aria-labelledby="common-cta-title">
        <div class="public-container cta-band__inner">
            <div>
                @if($homeCta['eyebrow'] !== '')<span class="eyebrow">{{ $homeCta['eyebrow'] }}</span>@endif
                <h2 id="common-cta-title">@include('public.partials.visual-copy', ['copy' => $homeCta['title']])</h2>
                <p>@include('public.partials.visual-copy', ['copy' => $homeCta['lead']])</p>
            </div>
            <div class="cta-band__actions">
                @foreach ($homeCta['actions'] as $action)
                    @php
                        $actionHref = $actionUrls[$action['key']] ?? null;
                        $actionClass = $action['key'] === 'line' ? 'button--line' : 'button--gold';
                    @endphp
                    @if ($actionHref !== null)
                        <a class="button {{ $actionClass }}" href="{{ $actionHref }}">
                            <span class="home-visual-action__copy"><strong>{{ $action['label'] }}</strong>@if($action['description'] !== '')<small>{{ $action['description'] }}</small>@endif</span><span aria-hidden="true">→</span>
                        </a>
                    @else
                        <button type="button" class="button {{ $actionClass }} is-disabled" disabled aria-label="{{ $site['ui']['line_unavailable_aria'] }}">
                            <span class="home-visual-action__copy"><strong>{{ $action['label'] }}</strong>@if($action['description'] !== '')<small>{{ $action['description'] }}</small>@endif</span><span aria-hidden="true">→</span>
                        </button>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@else
    <section class="cta-band" aria-labelledby="common-cta-title">
        <div class="public-container cta-band__inner">
            <div>
                <span class="eyebrow">{{ $site['ui']['cta']['eyebrow'] }}</span>
                <h2 id="common-cta-title">{!! nl2br(e($site['ui']['cta']['title'])) !!}</h2>
                <p>{{ $site['ui']['cta']['lead'] }}</p>
            </div>
            <div class="cta-band__actions">
                <a class="button button--light" href="{{ route('public.contact', ['locale' => $locale]) }}">{{ $site['ui']['cta']['contact'] }}</a>
                <a class="button button--outline button--on-dark" href="{{ route('public.process', ['locale' => $locale]) }}">{{ $site['ui']['cta']['process'] }}</a>
            </div>
        </div>
    </section>
@endif
