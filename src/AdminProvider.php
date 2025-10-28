<?php

namespace Merlion;

use Illuminate\Support\ServiceProvider;
use Merlion\Components\Layouts\Admin;

abstract class AdminProvider extends ServiceProvider
{
    public function register(): void
    {
        app()->resolving(
            AdminManager::class,
            fn(AdminManager $manager) => $manager->registerAdmin($this->admin(Admin::make())),
        );
    }

    abstract public function admin(Admin $admin): Admin;
}
