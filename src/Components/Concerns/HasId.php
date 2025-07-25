<?php

declare(strict_types=1);

namespace Merlion\Components\Concerns;

use Illuminate\Support\Str;

/**
 * @method $this id(mixed $id) Set id
 */
trait HasId
{
    public mixed $id = '';

    public function getId(): string
    {
        if (empty($this->id)) {
            $this->id = Str::slug(class_basename($this)) . '_' . uniqid();
        }
        return $this->id;
    }
}
