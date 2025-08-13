<?php
declare(strict_types=1);

namespace Merlion\Addons\Auth;

use Arr;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Merlion\Components\Layouts\Admin;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'merlion_auth');
        config(Arr::dot(config('merlion_auth.admin', []), 'merlion.admin.'));
        Admin::addBehavior('auth', new AuthBehavior());
    }

    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'merlion_auth');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'merlion');

        Admin::addStaticHook('booting', function () {
            Authenticate::redirectUsing(function () {
                return admin()->getRoute('login');
            });
        });
    }
}
