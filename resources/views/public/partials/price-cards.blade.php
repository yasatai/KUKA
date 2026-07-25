<div class="prices-card-grid" role="group" aria-label="{{ $prices['copy']['cards']['group_label'] }}">
    @forelse ($prices['metals'] as $metal)
        @php
            $trend = count($metal['trend']) > 0 ? $metal['trend'] : [$metal['representative']];
            $minimum = min($trend);
            $maximum = max($trend);
            $range = max($maximum - $minimum, 1);
            $points = collect($trend)->map(function ($value, $index) use ($trend, $minimum, $range) {
                $x = ($index / max(count($trend) - 1, 1)) * 190;
                $y = 54 - (($value - $minimum) / $range) * 38 - 8;
                return round($x, 2).','.round($y, 2);
            })->implode(' ');
            $grade = collect($metal['grades'])->where('is_active', true)->sortBy('sort_order')->first();
        @endphp
        <button type="button" class="prices-card" style="--prices-accent: {{ $metal['accent'] }}" data-metal-code="{{ $metal['code'] }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}">
            <span class="prices-card__heading"><span class="prices-card__symbol" aria-hidden="true">{{ $metal['symbol'] }}</span><strong>{{ $metal['name'] }}</strong><small>{{ $metal['englishName'] }}</small></span>
            <span class="prices-card__grade">{{ $prices['copy']['cards']['representative_grade'] }}: {{ $grade['code'] ?? '—' }}@if ($grade && $grade['display_name'] !== $grade['code']) ({{ $grade['display_name'] }})@endif</span>
            <span class="prices-card__price">{{ number_format($metal['representative']) }}<small>{{ $metal['unit'] }}</small></span>
            <span class="prices-card__change{{ $metal['change'] < 0 ? ' is-negative' : '' }}">{{ $prices['copy']['cards']['change'] }} {{ $metal['change'] >= 0 ? '+' : '' }}{{ number_format($metal['change']) }}</span>
            <svg class="prices-card__chart" viewBox="0 0 190 54" role="img" aria-label="{{ str_replace('{metal}', $metal['name'], $prices['copy']['cards']['chart_title']) }}" preserveAspectRatio="none"><line class="prices-card__chart-grid" x1="0" y1="48" x2="190" y2="48"/><polyline class="prices-card__chart-line" points="{{ $points }}" data-active="{{ $loop->first ? 'true' : 'false' }}"/></svg>
        </button>
    @empty
        <p class="prices-empty" role="status">{{ $prices['copy']['cards']['empty'] }}</p>
    @endforelse
</div>
<div class="sr-only">
    @foreach ($prices['metals'] as $metal)
        <table><caption>{{ str_replace('{metal}', $metal['name'], $prices['copy']['cards']['trend_table']) }}</caption><thead><tr><th scope="col">{{ $prices['copy']['cards']['point'] }}</th><th scope="col">{{ $prices['copy']['cards']['value'] }}</th></tr></thead><tbody>@foreach ($metal['trend'] as $value)<tr><th scope="row">{{ $loop->last ? $prices['copy']['cards']['today'] : str_replace('{count}', count($metal['trend']) - $loop->iteration, $prices['copy']['cards']['days_ago']) }}</th><td>{{ number_format($value) }} {{ $metal['unit'] }}</td></tr>@endforeach</tbody></table>
    @endforeach
</div>
