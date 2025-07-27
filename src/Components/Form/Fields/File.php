<?php
declare(strict_types=1);

namespace Merlion\Components\Form\Fields;

use Closure;

class File extends Field
{
    public $view = 'merlion::form.fields.file';

    public mixed $accept = null;
    public mixed $maxSize = null;

    public bool|Closure $multiple = false;

    public function multiple($multiple = true): static
    {
        $this->multiple = $multiple;
        return $this;
    }
}
