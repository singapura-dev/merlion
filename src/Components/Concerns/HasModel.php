<?php

declare(strict_types=1);

namespace Merlion\Components\Concerns;

/**
 * @method $this model($model) Set model
 */
trait HasModel
{
    public mixed $model = null;

    protected mixed $getValueUsing = null;

    public function getValueUsing($callback): static
    {
        $this->getValueUsing = $callback;
        return $this;
    }

    public function getValue(): mixed
    {
        if ($this->getValueUsing) {
            return $this->evaluate($this->getValueUsing);
        }
        return data_get($this->getModel(), $this->getName());
    }

    public function getModel(): mixed
    {
        if (!empty($this->model)) {
            return evaluate($this->model, $this);
        }
        if ($this->hasContext('model')) {
            return evaluate($this->getContext('model'));
        }

        if ($this->parent && method_exists($this->parent, 'getModel')) {
            return $this->parent->getModel();
        }

        return null;
    }

    public function getModelKey(): mixed
    {
        return $this->getModel()?->getKey() ?? null;
    }
}
