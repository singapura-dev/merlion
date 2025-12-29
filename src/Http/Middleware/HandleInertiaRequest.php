<?php

namespace Merlion\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Merlion\Components\Inertia;

class HandleInertiaRequest extends Middleware
{
    public function rootView(Request $request): string
    {
        return Inertia::$root;
    }

    public function share(Request $request): array
    {
        return [
            "nonce" => csp_nonce(),
            ...parent::share($request),
        ];
    }
}
