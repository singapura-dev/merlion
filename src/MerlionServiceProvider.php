<?php

declare(strict_types=1);

namespace Merlion;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Merlion\Console\Commands\Install;
use Merlion\Http\Middleware\MerlionAuthenticate;
use Merlion\Http\Middleware\MerlionMiddleware;

class MerlionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'merlion');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'merlion');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'merlion');
        $this->bootRoutes();
        if ($this->app->runningInConsole()) {
            $this->publishAssets();
            $this->commands([
                Install::class,
            ]);
        }
    }

    protected function bootRoutes(): void
    {
        $router = $this->app['router'];
        $router->aliasMiddleware('merlion', MerlionMiddleware::class);
        $router->aliasMiddleware('merlion_auth', MerlionAuthenticate::class);
    }

    protected function publishAssets(): void
    {
        $this->publishes([
            __DIR__ . '/../resources/dist/'      => public_path('vendor/merlion'),
            __DIR__ . '/../resources/assets/js'  => public_path('vendor/merlion/js'),
            __DIR__ . '/../resources/assets/css' => public_path('vendor/merlion/css'),
        ], 'merlion-assets');
    }
}
