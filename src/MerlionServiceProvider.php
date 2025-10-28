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

        $this->app->scoped(AdminManager::class, function () {
            return new AdminManager();
        });
    }

    public function boot(): void
    {
        $this->app['router']->aliasMiddleware('merlion', SetCurrentAdmin::class);
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'merlion');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'merlion');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->publishAssets();
    }

    protected function publishAssets(): void
    {
        $this->publishes([
            __DIR__ . '/../resources/assets/' => public_path('vendor/merlion/'),
        ], 'merlion-assets');
    }
}
