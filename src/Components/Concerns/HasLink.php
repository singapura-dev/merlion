<?php

declare(strict_types=1);

namespace Merlion\Components\Concerns;

/**
 * @method $this link(mixed $link, mixed $target = null) Set link
 * @method $this target(mixed $target) Set target
 * @method string getTarget() Get target
 */
trait HasLink
{
    public mixed $link = null;
    public mixed $target = null;
}
