<?php
declare(strict_types=1);

namespace Merlion\Components\Show\Grid;

class Select extends Text
{
    public array $options = [];

    public function getValue(): mixed
    {
        $value = parent::getValue();
        return $this->options[$value] ?? $value;
    }
}
