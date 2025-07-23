<?php
declare(strict_types=1);

namespace Merlion\Components\Form\Fields;

use Closure;
use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Renderable;

/**
 * @method $this rules(string|Closure|array $rules) Set rules
 * @method string|array|null getRules() Get rules
 */
abstract class Field extends Renderable
{
    use AsCell;

    protected array $dependsFields = [];

    public array|string|Closure|null $rules = null;

    public function getValue()
    {
        if (empty($this->value)) {
            if (isset($this->form)) {
                return data_get($this->form->getModel(), $this->name);
            }
        }

        return evaluate($this->value, $this);
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
