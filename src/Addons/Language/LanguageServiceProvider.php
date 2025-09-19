<?php
declare(strict_types=1);

namespace Merlion\Addons\Language;

use Illuminate\Support\ServiceProvider;
use Merlion\Components\Layouts\Admin;

class LanguageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Admin::addBehavior('language', new LanguageBehavior());
    }

    public function boot(): void
    {
    }
}
