<?php
declare(strict_types=1);

namespace Merlion\Components\Form\Fields;

/**
 * @method $this rows(int $rows) Set rows
 */
class Textarea extends Field
{
    protected string $view = 'merlion::form.fields.textarea';
    public int $rows = 3;
}
