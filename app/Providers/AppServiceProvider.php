<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \Filament\Auth\Http\Responses\Contracts\LogoutResponse::class,
            \App\Http\Responses\LogoutResponse::class
        );

        $candidates = [
            dirname($this->app->basePath(), 1) . '/public_html',
            dirname($this->app->basePath(), 2) . '/public_html',
        ];
        foreach ($candidates as $candidate) {
            if (is_dir($candidate)) {
                $this->app->usePublicPath($candidate);
                break;
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
