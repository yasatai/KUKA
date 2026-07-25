<section class="prices-cta" aria-labelledby="prices-cta-title">
    <div class="prices-cta__media" aria-hidden="true"><img src="{{ asset($prices['copy']['hero']['image']) }}" alt=""></div>
    <div class="public-container prices-cta__inner">
        <div class="prices-cta__copy"><h2 id="prices-cta-title">{{ $prices['copy']['final_cta']['title'] }}</h2><p>{{ $prices['copy']['final_cta']['lead'] }}</p></div>
        <div class="prices-cta__actions">
            <button class="prices-consult-button prices-consult-button--line" type="button" disabled aria-label="{{ $site['ui']['line_unavailable_aria'] }}"><span class="prices-consult-button__icon" aria-hidden="true">LINE</span><span><strong>{{ $prices['copy']['final_cta']['line'] }}</strong><small>{{ $prices['copy']['final_cta']['line_description'] }}</small></span><span aria-hidden="true">→</span></button>
            <a class="prices-consult-button prices-consult-button--contact" href="{{ route('public.contact', ['locale' => $locale]) }}"><span class="prices-consult-button__icon" aria-hidden="true">▣</span><span><strong>{{ $prices['copy']['final_cta']['contact'] }}</strong><small>{{ $prices['copy']['final_cta']['contact_description'] }}</small></span><span aria-hidden="true">→</span></a>
        </div>
    </div>
</section>
