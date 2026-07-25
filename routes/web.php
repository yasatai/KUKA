<?php

use App\Http\Controllers\PublicSiteController;
use App\Http\Middleware\ApplyPublicRobotsPolicy;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/ja');

Route::middleware(ApplyPublicRobotsPolicy::class)
    ->prefix('{locale}')
    ->whereIn('locale', ['ja', 'en', 'zh', 'ko'])
    ->group(function (): void {
        Route::get('/', [PublicSiteController::class, 'home'])->name('public.home');
        Route::get('/prices', [PublicSiteController::class, 'prices'])->name('public.prices');
        Route::get('/items', [PublicSiteController::class, 'items'])->name('public.items');
        Route::get('/process', [PublicSiteController::class, 'process'])->name('public.process');
        Route::get('/company', [PublicSiteController::class, 'company'])->name('public.company');
        Route::get('/news', [PublicSiteController::class, 'news'])->name('public.news');
        Route::get('/news/{slug}', [PublicSiteController::class, 'newsShow'])
            ->where('slug', '[a-z0-9-]+')
            ->name('public.news.show');
        Route::get('/contact', [PublicSiteController::class, 'contact'])->name('public.contact');
        Route::get('/contact/confirm', [PublicSiteController::class, 'contactStep'])->name('public.contact.confirm');
        Route::get('/contact/complete', [PublicSiteController::class, 'contactStep'])->name('public.contact.complete');
    });

Route::view('/admin/reset-password/{token}', 'admin.app')
    ->name('password.reset');

Route::view('/admin/{path?}', 'admin.app')
    ->where('path', '.*')
    ->name('admin.app');
