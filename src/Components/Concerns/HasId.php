<?php

declare(strict_types=1);

namespace Merlion\Components\Concerns;

use Illuminate\Support\Str;

trait HasId
{
    protected string $_id = '';

    public function id(string $id): static
    {
        $this->_id = $id;
        return $this;
    }

    public function getId(): string
    {
        if (empty($this->_id)) {
            $this->_id = Str::slug(class_basename($this)) . '_' . uniqid();
        }
        return $this->_id;
    }
}
