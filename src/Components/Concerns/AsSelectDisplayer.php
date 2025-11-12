<?php

declare(strict_types=1);

namespace Merlion\Components\Concerns;

/**
 * @method array getOptions()
 * @method bool getMultiple()
 * @method $this options(array|\Closure $options)
 * @method string getRelationship()
 * @method string getRelationshipTitleAttribute()
 */
trait AsSelectDisplayer
{
    public mixed $options = [];
    public mixed $multiple = false;

    public mixed $relationship = null;
    public mixed $relationshipTitleAttribute = 'name';


    public function diaplayValue()
    {
        $value   = $this->getValue();
        $options = $this->getOptions();
        if (!$this->getRelationship()) {
            return $options[$value] ?? $value;
        }

        $model = $this->getModel();
        $value = $model->{$this->getRelationship()}->pluck($this->getRelationshipTitleAttribute())->toArray();
        return implode(', ', $value);
    }
}
