<?php
declare(strict_types=1);

namespace Merlion\Components\Table\Columns\Actions;

use Merlion\Components\Table\Columns\Column;

class Action extends Column
{
    public string $element = 'a';

    public function button($class = 'btn'): static
    {
        $this->element = 'button';
        $this->class($class);
        return $this;
    }
}
