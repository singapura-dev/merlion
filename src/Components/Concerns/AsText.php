<?php

declare(strict_types=1);

namespace Merlion\Components\Concerns;

use Merlion\Enums\Color;

/**
 * @method $this|static labels(array|\Closure $labels)
 * @method array getLabels()
 * @method $this displayValueUsing(mixed $displayValueUsing)
 */
trait AsText
{
    use Copyable;
    use AsLink;
    use HasIcon;

    public mixed $displayValueUsing = null;
    public mixed $labels = [];

    public function diaplayValue()
    {
        if (!empty($this->displayValueUsing)) {
            return $this->evaluate($this->displayValueUsing);
        }
        return $this->getValue();
    }

    public function renderAsText()
    {
        if (!empty($labels = $this->getLabels())) {
            $value = $this->getValue();
            $color = 'primary';
            foreach ($labels as $_value => $_color) {
                if ($value == $_value) {
                    if ($_color instanceof Color) {
                        $_color = $_color->value;
                    }
                    $color = $_color;
                }
            }
            $this->class('badge bg-' . $color . ' text-' . $color . '-fg');
        }
    }
}
