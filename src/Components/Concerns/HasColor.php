<?php


declare(strict_types=1);

namespace Merlion\Components\Concerns;

use Illuminate\Support\Arr;

/**
 * @method $this|static color($color)
 * @method array getColor()
 */
trait HasColor
{
    public mixed $color = null;

    public function renderHasColor()
    {
        if (empty($this->color)) {
            return;
        }

        $this->class('badge');

        $value = $this->getValue();

        $colors = $this->getColor();

        if (!is_array($colors) || empty($colors)) {
            return;
        }

        if ($color = Arr::get($colors, $value)) {
            $this->class('bg-' . $color . '-lt');
        }
    }
}
