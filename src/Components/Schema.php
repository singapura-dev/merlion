<?php

declare(strict_types=1);

namespace Merlion\Components;

abstract class Schema extends Renderable
{
    public mixed $showOn = null;
    public mixed $hideFrom = null;

    public function shouldShow($action): bool
    {
        if (!empty($this->showOn)) {
            $showOn = $this->evaluate($this->showOn);
            $showOn = is_array($showOn) ? $showOn : [$showOn];
            return in_array($action, $showOn);
        }

        if (!empty($this->hideFrom)) {
            $hideFrom = $this->evaluate($this->hideFrom);
            $hideFrom = is_array($hideFrom) ? $hideFrom : [$hideFrom];
            return !in_array($action, $hideFrom);
        }

        return true;
    }
}
