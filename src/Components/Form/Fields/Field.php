<?php
declare(strict_types=1);

namespace Merlion\Components\Form\Fields;

use Closure;
use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Concerns\HasModel;
use Merlion\Components\Form\Form;
use Merlion\Components\Renderable;

/**
 * @method $this rules(string|Closure|array $rules) Set rules
 * @method string|array|null getRules() Get rules
 * @method Form getForm() Get form
 */
abstract class Field extends Renderable
{
    use AsCell;
    use HasModel;

    protected array $dependsFields = [];

    public bool $full = false;
    public mixed $form = null;
    public mixed $ignore = false;

    public array|string|Closure|null $rules = null;

    public static array $fieldsMap = [
        'text'     => Text::class,
        'textarea' => Textarea::class,
    ];

    public static function field(string $type, ...$args): Field
    {
        return static::$fieldsMap[$type]::make(...$args);
    }

    public function getValue()
    {
        if (!is_null($this->value)) {
            return $this->evaluate($this->value);
        }

        if (!empty($this->getModel())) {
            return data_get($this->getModel(), $this->name);
        }

        if (!empty($this->getForm())) {
            return data_get($this->getForm()->getModel(), $this->name);
        }
        return null;
    }

    public function dependsOn(string $name, array|string|bool $values = true): static
    {
        $this->dependsFields[] = [
            'name'   => $name,
            'values' => $values,
        ];
        return $this;
    }

    public function dependsFields(): array
    {
        return $this->dependsFields;
    }
}
