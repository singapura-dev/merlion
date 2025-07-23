<?php

declare(strict_types=1);

namespace Merlion\Components;

use Illuminate\Support\Str;

class Icon extends Container
{
    public string $wrapper = 'i';

    public function __construct(...$args)
    {
        if (is_string($args[0] ?? null)) {
            $this->class('icon');
            $prefix = Str::before($args[0], '-');
            switch ($prefix) {
                case 'flag':
                    $this->class('flag ' . $args[0]);
                    break;
                case 'ti':
                    $this->class('ti ' . $args[0]);
                    break;
                default:
                    $this->class($args[0]);
                    break;
            }
            return;
        }
        parent::__construct(...$args);
    }
}
