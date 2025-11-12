<?php
declare(strict_types=1);

namespace Merlion\Components\Form\Fields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Merlion\Components\Concerns\AsInput;

/**
 * @method $this options($options)
 * @method string getRelationshipTitleAttribute()
 */
class Select extends Field
{
    use AsInput;

    public mixed $creatable = false;

    public bool $nullable = false;
    public mixed $nullableLabel = '-';

    public mixed $options = [];
    public mixed $multiple = false;

    public mixed $relationship = null;
    public mixed $relationshipTitleAttribute = null;

    public function relationship($name = null, $titleAttrubute = 'name')
    {
        $this->relationship               = $name ?: $this->getName();
        $this->relationshipTitleAttribute = $titleAttrubute;
    }

    public function renderSelect()
    {
        if (!empty($this->relationship)) {
            $model = $this->getModel();

            if (is_string($model)) {
                /**
                 * @var Model $model
                 */
                $model = $model::query();
            }

            $relation       = $model->{$this->getName()}();
            $relation_model = $relation->getModel();
            $title          = $this->getRelationshipTitleAttribute();
            $key            = $relation->getRelatedKeyName();

            $this->options = $relation_model::query()->get()->pluck($title, $key)->toArray();

            $relatedTable = $relation->getRelated()->getTable();
            $relatedKey   = $relation->getRelatedKeyName();

            $this->value = $model->{$this->getName()}()->pluck($relatedTable . '.' . $relatedKey)->toArray();
        }
    }

    public function save($model)
    {
        $model->{$this->getName()} = $this->getDataFromRequest();
        return $model;
    }

    public function saveRelationship($model)
    {
        $relationship = $this->getRelationship();
        if (empty($relationship)) {
            return;
        }

        $relation = $model->{$relationship}();
        switch (get_class($relation)) {
            case BelongsToMany::class:
                $relation->sync($this->getDataFromRequest());
                break;
        }
    }
}
