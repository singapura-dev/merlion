<?php
declare(strict_types=1);

namespace Merlion\Components\Table\Columns;

/**
 * @method array getOptions()
 * @method $this options(array|\Closure $options)
 */
class Select extends Text
{
    public mixed $options;

    public function diaplayValue()
    {
        $value = $this->getValue();
        $options = $this->getOptions();
        return $options[$value] ?? $value;
    }
}
