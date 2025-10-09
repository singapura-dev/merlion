<?php

declare(strict_types=1);

namespace Merlion\Components\Concerns;

use Illuminate\Support\Str;

trait HasId
{
    protected mixed $id = null;

    public function id(mixed $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): mixed
    {
        if (empty($this->id)) {
            $this->id = $this->defaultId();
        }
        return $this->evaluate($this->id);
    }

    protected function defaultId(): string
    {
        return Str::lower(class_basename($this));
    }

    protected function buildHasId(): void
    {
        if (!empty($id = $this->getId())) {
            $this->withAttributes(['id' => $id]);
        }
    }
}
