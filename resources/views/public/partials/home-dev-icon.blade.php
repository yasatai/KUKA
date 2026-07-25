@switch($name)
    @case('gift')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
            <g fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <rect x="5" y="12" width="22" height="15" rx="1"/><path d="M16 12v15M4 12h24V8H4v4Z"/>
                <path d="M16 8c-1.5-4.7-7.2-5-7.2-1.5C8.8 9 12 9 16 9M16 8c1.5-4.7 7.2-5 7.2-1.5C23.2 9 20 9 16 9"/>
            </g>
        </svg>
        @break
    @case('chart')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
            <g fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 27V5M5 27h22"/><path d="M9 23v-6h4v6M15 23V12h4v11M21 23V8h4v15"/>
                <path d="m9 13 5-5 4 2 7-6M21 4h4v4"/>
            </g>
        </svg>
        @break
    @case('line')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
            <circle class="home-line-icon__circle" cx="16" cy="16" r="15" fill="currentColor"/>
            <path class="home-line-icon__bubble" d="M24.5 15.2c0-4.3-3.9-7.7-8.8-7.7s-8.8 3.4-8.8 7.7c0 3.8 3.1 7 7.3 7.6.6.1 1.4.4 1.6.9.2.4.1 1.1.1 1.5l-.2 1.4c-.1.4-.3 1.6 1.5.9 1.8-.8 9.8-5.8 9.8-12.3Z" fill="#fff"/>
            <path class="home-line-icon__letters" d="M11 13v4.6h2.5M14.8 13v4.6M17 17.6V13l3.1 4.6V13M21.4 13v4.6h3" fill="none" stroke="currentColor" stroke-width=".9" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        @break
    @case('payment')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
            <circle cx="16" cy="16" r="14" fill="none" stroke="currentColor" stroke-width="1.6"/>
            <path d="m10 8 6 8 6-8M10.5 16h11M10.5 20h11M16 16v9" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        @break
    @case('contact')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
            <rect x="7" y="3.5" width="18" height="25" rx="1" fill="none" stroke="currentColor" stroke-width="1.6"/>
            <rect x="10" y="7" width="12" height="5" fill="none" stroke="currentColor" stroke-width="1.4"/>
            <g fill="currentColor"><circle cx="11.5" cy="16" r="1.2"/><circle cx="16" cy="16" r="1.2"/><circle cx="20.5" cy="16" r="1.2"/><circle cx="11.5" cy="20.5" r="1.2"/><circle cx="16" cy="20.5" r="1.2"/><circle cx="20.5" cy="20.5" r="1.2"/><circle cx="11.5" cy="25" r="1.2"/><circle cx="16" cy="25" r="1.2"/><circle cx="20.5" cy="25" r="1.2"/></g>
        </svg>
        @break
    @case('store')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13h22v15H5zM3 13l4-8h18l4 8M10 28V18h12v10"/><path d="M3 13c0 2 4 3 6 0 2 3 5 3 7 0 2 3 5 3 7 0 2 3 6 2 6 0"/></g></svg>
        @break
    @case('receipt')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3h16v26l-3-2-3 2-2-2-3 2-2-2-3 2zM12 9h8M12 14h8M12 19h5"/></g></svg>
        @break
    @case('inspect')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="14" cy="14" r="8"/><path d="m20 20 8 8M10 14h8M14 10v8"/></g></svg>
        @break
    @case('quote')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 27V6h22v21zM9 22h14M9 17h8M9 12h5"/><path d="m21 9 2 2-5 5-3 1 1-3z"/></g></svg>
        @break
    @case('identity')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="7" width="26" height="19" rx="1"/><circle cx="11" cy="15" r="3"/><path d="M6 23c1-4 9-4 10 0M19 13h6M19 18h6"/></g></svg>
        @break
    @case('phone')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false"><path d="M8 4c2 0 4 5 4 6 0 1-2 2-3 3 2 5 5 8 10 10 1-1 2-3 3-3 1 0 6 2 6 4 0 3-3 5-6 5C13 28 4 19 3 10 3 7 5 4 8 4Z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        @break
    @case('shield')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M16 3 27 7v8c0 7-4.7 11.8-11 14-6.3-2.2-11-7-11-14V7l11-4Z"/><path d="m11 16 3 3 7-7"/></g></svg>
        @break
    @case('clock')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="16" cy="17" r="12"/><path d="M16 10v7l5 3M12 3h8"/></g></svg>
        @break
    @case('visibility')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 16s5-8 13-8 13 8 13 8-5 8-13 8S3 16 3 16Z"/><circle cx="16" cy="16" r="4"/><path d="M21 6h6v6"/></g></svg>
        @break
    @case('expert')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10 5h12l4 7-10 15L6 12l4-7Z"/><path d="m6 12 10 4 10-4M10 5l6 11 6-11"/><circle cx="24" cy="23" r="5"/><path d="m28 27 3 3"/></g></svg>
        @break
    @case('ingot')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"><path d="m7 11 4-6h10l4 6-3 9H10l-3-9Z"/><path d="m3 21 3-5h8l3 5-2 6H5l-2-6ZM18 22l3-5h7l2 5-2 5h-8l-2-5Z"/></g></svg>
        @break
    @case('coin')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="17" r="8"/><circle cx="21" cy="14" r="8"/><path d="M21 10v8M18 14h6"/></g></svg>
        @break
    @case('jewelry')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 5 7 10L23 5M9 5h14l5 6-12 16L4 11l5-6Z"/><circle cx="16" cy="22" r="5"/></g></svg>
        @break
    @case('tableware')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"><path d="M8 3v10M5 3v7c0 3 6 3 6 0V3M8 13v16M22 3c-5 4-5 12 0 14v12M22 3v14"/></g></svg>
        @break
    @case('scrap')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="m7 8 7-4 4 7-7 4-4-7ZM18 18l7-4 4 7-7 4-4-7ZM5 22h10v6H5z"/><path d="m13 15 7-4M14 22l4-2"/></g></svg>
        @break
    @case('certificate')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="3" width="22" height="20" rx="1"/><path d="M10 8h12M10 12h12M10 16h7"/><circle cx="21" cy="21" r="5"/><path d="m18 25-1 5 4-2 4 2-1-5"/></g></svg>
        @break
    @case('team')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"><circle cx="16" cy="10" r="4"/><circle cx="7" cy="13" r="3"/><circle cx="25" cy="13" r="3"/><path d="M8 27c0-6 3-9 8-9s8 3 8 9M2 26c0-5 2-8 6-8M30 26c0-5-2-8-6-8"/></g></svg>
        @break
    @case('scales')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4v24M9 28h14M6 8h20M10 8 5 18h10L10 8ZM22 8l-5 10h10L22 8Z"/><path d="M5 18c1 4 9 4 10 0M17 18c1 4 9 4 10 0"/></g></svg>
        @break
    @case('calendar')
        <svg class="home-dev-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"><rect x="4" y="6" width="24" height="22" rx="1"/><path d="M4 12h24M10 3v6M22 3v6M9 17h3M15 17h3M21 17h3M9 22h3M15 22h3M21 22h3"/></g></svg>
        @break
@endswitch
