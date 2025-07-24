<?php


declare(strict_types=1);

namespace Merlion\Components\Concerns;

/**
 * @method $this model(mixed $model) Set model
 * @method mixed getModel() Get model
 */
trait HasModel
{
    public mixed $model = null;
}
