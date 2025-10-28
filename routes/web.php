<?php

use Merlion\AdminManager;
use Merlion\Components\Layouts\Admin;
use Merlion\Http\Controllers\Api\FormSubmitController;
use Merlion\Http\Controllers\Api\LazyRenderController;
use Merlion\Http\Controllers\Auth\LoginController;

foreach (app(AdminManager::class)->getAdmins() as $admin) {
    /**
     * @var Admin $admin
     */
    $domains = $admin->getDomains();
    foreach ((empty($domains) ? [null] : $domains) as $domain) {
        Route::prefix($admin->getPath())
            ->domain($domain)
            ->name($admin->getId() . '.')
            ->middleware($admin->getMiddleware())
            ->group(function () use ($admin) {

                foreach ($admin->getRoutes() as $routes) {
                    $routes($admin);
                }

                if (config('merlion.admin.api_routes_enabled')) {
                    Route::group([
                        'prefix' => 'api',
                        'as'     => 'api.',
                    ], function () {
                        Route::get('lazy-render', LazyRenderController::class)->name('lazy-render');
                        Route::post('form-submit', FormSubmitController::class)->name('form-submit');
                    });
                }

                if ($admin->hasLogin()) {
                    Route::name('auth.')->group(function () {
                        Route::get('login', [LoginController::class, 'showLogin'])->name('login');
                        Route::post('login', [LoginController::class, 'submitLogin'])->name('login.post');
                    });
                }
                Route::middleware($admin->getAuthMiddleware())
                    ->group(function () use ($admin) {
                        foreach ($admin->getAuthenticatedRoutes() as $routes) {
                            $routes($admin);
                        }

                        if (!empty($home_url = $admin->getHomeUrl())) {
                            Route::get($home_url, admin()->getHome())->name('home');
                        }

                        if ($admin->hasLogin()) {
                            Route::get('logout', [LoginController::class, 'logout'])->name('auth.logout');
                        }
                    });
            });
    }
}
