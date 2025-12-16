<?php

declare(strict_types=1);

namespace Merlion\Http\Controllers;

class Home
{
    public function __invoke()
    {
        return admin()->content('This is home page, can change by admin()->home(YourHome::class)')->render();
    }
}
