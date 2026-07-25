<section class="page-hero" aria-labelledby="page-title">
    <img class="page-hero__image" src="{{ asset($hero['image']) }}" alt="{{ $hero['alt'] }}" width="1792" height="1024">
    <div class="page-hero__inner">
        <div class="page-hero__content" data-hero-content>
            <span class="eyebrow">{{ $hero['eyebrow'] }}</span>
            <h1 id="page-title">{!! nl2br(e($hero['title'])) !!}</h1>
            <p class="page-hero__lead">{{ $hero['lead'] }}</p>
            @if (!empty($hero['actions']))
                <div class="page-hero__actions">
                    @foreach ($hero['actions'] as $action)
                        <a class="button {{ $action['style'] ?? '' }}" href="{{ $action['href'] }}">{{ $action['label'] }}</a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>
