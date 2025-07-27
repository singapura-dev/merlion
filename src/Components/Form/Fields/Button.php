<?php
declare(strict_types=1);

namespace Merlion\Components\Form\Fields;

use Merlion\Components\Concerns\AsButton;
use Merlion\Components\Concerns\HasIcon;

class Button extends Field
{
    use AsButton;
    use HasIcon;

    public $view = 'merlion::form.fields.button';
    public mixed $ignore = true;
}
