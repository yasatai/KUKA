@php
    $footerNavigation = collect($site['navigation'])->keyBy('page_key');
    $footerHref = static function (?string $pageKey) use ($footerNavigation): ?string {
        if ($pageKey === null) {
            return null;
        }

        $item = $footerNavigation->get($pageKey);

        return is_array($item) && isset($item['href']) ? (string) $item['href'] : null;
    };
@endphp

<footer class="site-footer kuka-footer" data-public-footer>
    <h2 class="sr-only">{{ $site['ui']['footer_navigation'] }}</h2>
    <div class="public-container kuka-footer__main">
        <div class="kuka-footer__brand">
            <a class="kuka-footer__logo" href="{{ route('public.home', ['locale' => $locale]) }}" aria-label="{{ $site['brand']['name'] }} {{ $site['ui']['home'] }}">
                <span class="kuka-footer__logo-frame" aria-hidden="true">
                    <img src="{{ asset('images/brand/kuka-footer-logo.png') }}" alt="" width="834" height="978">
                </span>
            </a>
            <p class="kuka-footer__brand-copy">{{ $footer['brand']['description'] }}</p>
            <p class="kuka-footer__specialty">{{ $footer['brand']['specialty'] }}</p>
        </div>

        <nav class="kuka-footer__navigation" aria-label="{{ $site['ui']['footer_navigation'] }}">
            @foreach ($footer['groups'] as $group)
                @php($groupHref = $footerHref($group['page_key']))
                <details class="kuka-footer-group" data-footer-group="{{ $group['key'] }}" open>
                    <summary>{{ $group['title'] }}</summary>
                    <div class="kuka-footer-group__links">
                        @foreach ($group['links'] as $link)
                            @php($linkHref = $link['enabled'] ? $footerHref($link['page_key']) : null)
                            @if ($linkHref !== null)
                                <a href="{{ $linkHref }}">{{ $link['label'] }}</a>
                            @else
                                <span class="kuka-footer-link--disabled" aria-disabled="true" title="{{ $footer['disabled_label'] }}">{{ $link['label'] }}</span>
                            @endif
                        @endforeach
                    </div>
                </details>
            @endforeach
        </nav>

        <aside class="kuka-footer__contact" aria-labelledby="kuka-footer-contact-title">
            <h3 id="kuka-footer-contact-title">{{ $footer['contact']['title'] }}</h3>
            <p>{{ $footer['contact']['lead'] }}</p>
            <div class="kuka-footer__contact-links">
                @foreach ($footer['contact']['links'] as $link)
                    @php($contactHref = $link['enabled'] ? $footerHref($link['page_key']) : null)
                    @if ($contactHref !== null)
                        <a class="kuka-footer__contact-primary" href="{{ $contactHref }}">{{ $link['label'] }} <span aria-hidden="true">→</span></a>
                    @else
                        <span class="kuka-footer__contact-disabled" aria-disabled="true" title="{{ $footer['disabled_label'] }}">{{ $link['label'] }}</span>
                    @endif
                @endforeach
            </div>
        </aside>
    </div>

    <div class="public-container kuka-footer__bottom">
        <div class="kuka-footer__legal" aria-label="{{ $footer['legal']['title'] }}">
            <strong>{{ $footer['legal']['title'] }}</strong>
            @foreach ($footer['legal']['links'] as $link)
                @php($legalHref = $link['enabled'] ? $footerHref($link['page_key']) : null)
                @if ($legalHref !== null)
                    <a href="{{ $legalHref }}">{{ $link['label'] }}</a>
                @else
                    <span aria-disabled="true" title="{{ $footer['disabled_label'] }}">{{ $link['label'] }}</span>
                @endif
            @endforeach
        </div>
        <div class="kuka-footer__meta">
            <span>{{ $footer['legal']['copyright'] }}</span>
            <span>{{ $footer['legal']['release_note'] }}</span>
        </div>
    </div>
</footer>
