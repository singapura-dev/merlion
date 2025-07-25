<?php
declare(strict_types=1);

namespace Merlion\Http\Controllers;

class LanguageController
{
    public function __invoke($locale)
    {
        app()->setLocale($locale);
        admin()->setLanguage(app()->getLocale());
        if (auth()->user()) {
            try {
                auth()->user()->language = app()->getLocale();
                auth()->user()->save();
            } catch (\Exception $e) {
            }
        }
        return back();
    }
}
