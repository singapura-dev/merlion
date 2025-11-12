<?php
declare(strict_types=1);

namespace Merlion\Components\Form\Fields;

use Closure;
use Exception;
use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Concerns\HasContent;
use Merlion\Components\Concerns\HasModel;
use Merlion\Components\Form\Form;
use Merlion\Components\Schema;

/**
 * @method $this rules(string|Closure|array $rules) Set rules
 * @method string|array|null getRules() Get rules
 * @method Form getForm() Get form
 * @method bool getRelationship() If this field is a relationship
 */
abstract class Field extends Schema
{
    use HasContent;
    use AsCell;
    use HasModel;

    public static array $fieldsMap = [
        'text'          => Text::class,
        'file'          => File::class,
        'image'         => Image::class,
        'textarea'      => Textarea::class,
        'select'        => Select::class,
        'editor'        => Editor::class,
        'toggle'        => Toggle::class,
        'json'          => Json::class,
        'belongsToMany' => BelongsToMany::class,
    ];

    public mixed $form = null;
    public mixed $ignore = false;
    public mixed $relationship = false;

    public array|string|Closure|null $rules = null;
    protected array $dependsFields = [];

    public static function generate($field): Field
    {
        if (is_string($field)) {
            $field = [
                'name' => $field,
                'type' => 'text',
            ];
        }

        if (is_array($field)) {
            $field_class = static::$fieldsMap[$field['type'] ?? 'text'] ?? Text::class;
            unset($field['type']);
            $field = $field_class::make($field);
        }

        if ($field instanceof Field) {
            return $field;
        }

        throw new Exception('Invalid field');
    }

    public function getValue()
    {
        if (!is_null($this->value)) {
            return $this->evaluate($this->value);
        }

        if (!empty($model = $this->getModel())) {
            return data_get($model, $this->getName());
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

    public function getDataFromRequest($request = null)
    {
        if (empty($request)) {
            $request = request();
        }

        return $request->input($this->getName());
    }

    public function save($model)
    {
        $model->{$this->getName()} = $this->getDataFromRequest();
        return $model;
    }
}
