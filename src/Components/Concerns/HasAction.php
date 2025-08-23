<?php

declare(strict_types=1);

namespace Merlion\Components\Concerns;

use Closure;

/**
 * @method string getMethod()
 * @method string getAction()
 * @method $this method(string|Closure $method)
 */
trait HasAction
{
    public mixed $method = 'post';
    public mixed $action = null;

    public function put($action): static
    {
        return $this->action($action, 'put');
    }

    public function post($action): static
    {
        return $this->action($action, 'post');
    }

    public function action($action, $method = null): static
    {
        $this->action = $action;
        if ($method) {
            $this->method = $method;
        }
        return $this;
    }
}
