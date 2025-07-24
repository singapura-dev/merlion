<?php

declare(strict_types=1);

namespace Merlion;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Merlion\Http\Middleware\MerlionMiddleware;

class MerlionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'merlion');
        if (config('merlion.auth_enabled')) {
            config(Arr::dot(config('merlion.auth', []), 'auth.'));
        }
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'merlion');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'merlion');

        $this->bootRoutes();

        if ($this->app->runningInConsole()) {
            $this->publishAssets();
        }

        Paginator::useBootstrapFive();
    }

    protected function bootRoutes(): void
    {
        Route::middleware(['web', MerlionMiddleware::class])
            ->prefix(config('merlion.route.prefix'))
            ->as(config('merlion.route.as'))
            ->group(function () {
                require __DIR__ . '/../routes/web.php';
                if (config('merlion.auth_enabled')) {
                    require __DIR__ . '/../routes/auth.php';
                }
            });
    }

    protected function publishAssets(): void
    {
        $this->publishes([
            __DIR__ . '/../resources/dist/assets/' => public_path('vendor/merlion'),
        ], 'merlion-assets');
    }
}
