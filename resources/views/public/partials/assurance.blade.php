<section class="assurance-strip" aria-label="ご案内">
    <div class="public-container assurance-strip__grid">
        @foreach ($site['assurances'] as $assurance)
            <div class="assurance-strip__item">
                <h2>{{ $assurance['title'] }}</h2>
                <p>{{ $assurance['description'] }}</p>
            </div>
        @endforeach
    </div>
</section>
