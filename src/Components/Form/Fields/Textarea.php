<?php
declare(strict_types=1);

namespace Merlion\Components\Form\Fields;

use Closure;

/**
 * @method $this rows(int|Closure $rows) Set rows
 */
class Textarea extends Text
{
    protected string $view = 'merlion::form.fields.textarea';
    public mixed $rows = 3;
}
