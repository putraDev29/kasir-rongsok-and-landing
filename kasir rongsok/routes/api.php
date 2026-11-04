<?php

use App\Http\Controllers\Api\LandingPageApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public API Routes for Landing Page
|--------------------------------------------------------------------------
*/

Route::prefix('landing-page')->group(function () {
    Route::get('/', [LandingPageApiController::class, 'index'])->name('api.landing-page.index');
    Route::get('/settings', [LandingPageApiController::class, 'settings'])->name('api.landing-page.settings');
    Route::get('/services', [LandingPageApiController::class, 'services'])->name('api.landing-page.services');
    Route::get('/categories', [LandingPageApiController::class, 'categories'])->name('api.landing-page.categories');
    Route::get('/gallery', [LandingPageApiController::class, 'gallery'])->name('api.landing-page.gallery');
    Route::get('/testimonials', [LandingPageApiController::class, 'testimonials'])->name('api.landing-page.testimonials');
    Route::post('/testimonials', [LandingPageApiController::class, 'submitTestimonial'])->name('api.landing-page.testimonials.submit');
    Route::get('/faqs', [LandingPageApiController::class, 'faqs'])->name('api.landing-page.faqs');
    Route::get('/statistics', [LandingPageApiController::class, 'statistics'])->name('api.landing-page.statistics');
    Route::post('/contact', [LandingPageApiController::class, 'contact'])->name('api.landing-page.contact');
});

