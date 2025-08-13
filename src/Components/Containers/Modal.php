<?php


declare(strict_types=1);

namespace Merlion\Components\Containers;

use Closure;
use Merlion\Components\Concerns\HasContent;
use Merlion\Components\Renderable;

/**
 * @method $this title(string|Closure $title) Set title
 */
class Modal extends Renderable
{
    use HasContent;

    public bool $closable = true;
    public mixed $title = "Modal title";
    public string $size = '';

    public function large(): static
    {
        $this->size = 'lg';
        return $this;
    }

    public function xtraLarge(): static
    {
        $this->size = 'xl';
        return $this;
    }

    public function small(): static
    {
        $this->size = 'sm';
        return $this;
    }

    public function backdrop($backdrop = 'static'): static
    {
        return $this->withAttributes(['data-bs-backdrop' => $backdrop]);
    }

    public function keyboard($keyboard = 'false'): static
    {
        return $this->withAttributes(['data-bs-keyboard' => $keyboard]);
    }

    public function lazy($renderable, $context = []): static
    {
        $lazy = Lazy::make()->renderable($renderable)->context($context);
        $this->content($lazy);
        return $this;
    }

    protected function defaultId(): string
    {
        return 'modal_' . uniqid();
    }
}
