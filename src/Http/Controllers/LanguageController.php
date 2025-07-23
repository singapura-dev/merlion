<?php
declare(strict_types=1);

namespace Merlion\Http\Controllers;

class LanguageController
{
    public function __invoke($locale)
    {
        admin()->setCurrentLanguage($locale);
        return back();
    }
}
