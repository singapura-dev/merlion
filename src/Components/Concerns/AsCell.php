<?php
declare(strict_types=1);

namespace Merlion\Components\Concerns;

use Closure;
use Illuminate\Support\Str;

/**
 * @method $this label(string|Closure $label) Set field label
 * @method $this name(string|Closure $name) Set field name
 * @method $this value(string|Closure $value) Set field value
 * @method string|null getName() Get field name
 * @method mixed getValue() Get field value
 */
trait AsCell
{
    public mixed $name = null;
    public mixed $label = null;
    public mixed $value = null;
    public mixed $noLabel = false;

    public function __construct(...$args)
    {
        if (is_string($args[0] ?? null)) {
            $this->name($args[0]);

            if (is_string($args[1] ?? null)) {
                $this->label($args[1]);
            }
            return;
        }
        parent::__construct(...$args);
    }

    public function noLabel($noLabel = true): static
    {
        $this->noLabel = $noLabel;
        return $this;
    }

    public function getLabel()
    {
        if ($this->noLabel) {
            return null;
        }

        if (!empty($this->label)) {
            return evaluate($this->label, $this);
        }

        return $this->defaultLabel();
    }

    protected function defaultLabel(): ?string
    {
        if ($this->label === ' ') {
            return '';
        }
        return Str::title($this->getName());
    }

    protected function defaultId(): string
    {
        return $this->getName() ?: Str::lower(class_basename($this)) . '_' . uniqid();
    }
}
