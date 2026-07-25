@php
    $desktopLines = array_values(array_filter($copy['desktop_lines'] ?? [], static fn (mixed $line): bool => is_string($line) && $line !== ''));
    $hasDesktopLines = count($desktopLines) > 0;
@endphp
<span class="home-copy-natural{{ $hasDesktopLines ? ' home-copy-natural--has-desktop-lines' : '' }}">{{ $copy['text'] }}</span>
@if ($hasDesktopLines)
    <span class="home-copy-desktop" aria-hidden="true">
        @foreach ($desktopLines as $line)
            <span>{{ $line }}</span>
        @endforeach
    </span>
@endif
