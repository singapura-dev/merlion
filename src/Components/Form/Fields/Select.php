<?php
declare(strict_types=1);

namespace Merlion\Components\Form\Fields;

use Closure;

/**
 * @method $this options(array|Closure $options) Set options
 */
class Select extends Field
{
    public $view = 'merlion::form.fields.select';
    public array|Closure $options = [];
}
