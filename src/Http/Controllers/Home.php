<?php

declare(strict_types=1);

namespace Merlion\Http\Controllers;

class Home
{
    public function __invoke()
    {
        return admin()->context('Home')->render();
    }
}
