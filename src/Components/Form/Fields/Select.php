<?php
declare(strict_types=1);

namespace Merlion\Components\Form\Fields;

use Merlion\Components\Concerns\AsInput;

/**
 * @method $this options($options)
 */
class Select extends Field
{
    use AsInput;

    public mixed $options = [];
}
