<?php
declare(strict_types=1);

namespace Merlion\Components;

use Closure;
use Merlion\Components\Concerns\AsLink;
use Merlion\Components\Concerns\HasIcon;
use Merlion\Components\Concerns\HasModal;

/**
 * @method $this label(string|Closure $label) Set button label
 */
class Button extends Renderable
{
    use HasIcon;
    use AsLink;
    use HasModal;

    public mixed $label = 'Button';

    protected array $defaultAttributes = [
        'class' => 'btn',
    ];

    public function submit(): static
    {
        return $this->withAttributes(['type' => 'submit']);
    }

    public function primary(): static
    {
        $this->class('btn-primary');
        return $this;
    }
}
