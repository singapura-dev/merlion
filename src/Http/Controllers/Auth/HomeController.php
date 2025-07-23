<?php

namespace Merlion\Http\Controllers\Auth;


use Merlion\Components\Pages\Home;

class HomeController
{
    public function __invoke()
    {
        return admin()->content(Home::make())->render();
    }
}
