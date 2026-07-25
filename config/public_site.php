<?php

return [
    'indexing' => filter_var(env('PUBLIC_SITE_INDEXING', false), FILTER_VALIDATE_BOOL),

    'locales' => [
        'ja' => ['html_lang' => 'ja', 'og_locale' => 'ja_JP'],
        'en' => ['html_lang' => 'en', 'og_locale' => 'en_US'],
        'zh' => ['html_lang' => 'zh-CN', 'og_locale' => 'zh_CN'],
        'ko' => ['html_lang' => 'ko', 'og_locale' => 'ko_KR'],
    ],

    'page_routes' => [
        'home' => 'public.home',
        'prices' => 'public.prices',
        'items' => 'public.items',
        'process' => 'public.process',
        'company' => 'public.company',
        'news' => 'public.news',
        'news_show' => 'public.news.show',
        'contact' => 'public.contact',
    ],

    /* Used by feature tests without editing .env or production fixture files. */
    'publication_overrides' => [],
];
