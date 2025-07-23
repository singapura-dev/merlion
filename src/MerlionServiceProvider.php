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

        Route::middleware(['web', MerlionMiddleware::class])
            ->prefix(config('merlion.route.prefix'))
            ->as(config('merlion.route.as'))
            ->group(function () {
                require __DIR__ . '/../routes/web.php';
                if (config('merlion.auth_enabled')) {
                    require __DIR__ . '/../routes/auth.php';
                }
            });

        $this->publishAssets();

        Paginator::useBootstrapFive();
    }

    protected function publishAssets()
    {
        $this->publishes([
            __DIR__ . '/../resources/dist/assets/' => public_path('vendor/merlion'),
        ], 'merlion-assets');
    }
}
