<?php

namespace Merlion\Http\Controllers\Auth;


use Merlion\Components\Pages\Home;

class HomeController
{
    public function __invoke()
    {
        $home = Home::make();
        return admin()->content($home)->render();
    }
}
