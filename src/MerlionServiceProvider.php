<?php
declare(strict_types=1);

namespace Merlion;

use Illuminate\Support\ServiceProvider;
use Merlion\Http\Middleware\SetCurrentAdmin;

class MerlionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/merlion.php', 'merlion');

        $addons = config('merlion.providers', []);
        foreach ($addons as $addon) {
            $this->app->register($addon);
        }
    }

    public function boot(): void
    {
        $this->app['router']->aliasMiddleware('merlion', SetCurrentAdmin::class);
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'merlion');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'merlion');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->publishAssets();
    }

    protected function publishAssets(): void
    {
        $this->publishes([
            __DIR__ . '/../resources/dist/' => public_path('vendor/merlion'),
            __DIR__ . '/../resources/assets/js/' => public_path('vendor/merlion/js'),
            __DIR__ . '/../resources/assets/css/' => public_path('vendor/merlion/css'),

        ], 'merlion-assets');
    }
}
