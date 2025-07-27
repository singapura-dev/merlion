<?php

declare(strict_types=1);

namespace Merlion\Components\Container;

use Merlion\Components\Renderable;

/**
 * @method $this setWrapper($wrapper) set lazy container wrapper, like div, span etc
 */
class Lazy extends Renderable
{
    public $view = 'merlion::lazy';
    public string $wrapper = 'div';
    public bool $auto = true;

    public function __construct(
        protected ?string $renderable = '',
        ?array $payload = null
    ) {
        if (!empty($payload)) {
            $this->payload($payload);
        }
    }

    public function content($renderable): static
    {
        $this->renderable = $renderable;
        return $this;
    }

    public function payload($payload = null): array|static
    {
        if (empty($payload)) {
            return evaluate($this->context('payload') ?? []);
        }
        $this->context('payload', $payload);
        return $this;
    }

    public function auto(bool $auto): static
    {
        $this->auto = $auto;
        return $this;
    }
}
