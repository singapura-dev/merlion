<?php

declare(strict_types=1);

namespace Merlion\Components\Form;

use Merlion\Components\Button;
use Merlion\Components\Concerns\AsFlex;
use Merlion\Components\Concerns\HasModel;
use Merlion\Components\Form\Fields\Field;
use Merlion\Components\Renderable;

class Form extends Renderable
{
    use HasModel;
    use AsFlex;

    public $view = 'merlion::form.form';

    public mixed $method = 'post';
    public mixed $container = null;
    public array $fields = [];
    public mixed $fieldContext = [];

    public bool $hideLabel = false;

    public function fields($fields): static
    {
        $fields = is_array($fields) ? $fields : [$fields];
        array_push($this->fields, ...$fields);
        return $this;
    }

    public function getFields(): array
    {
        $fields = [];
        foreach ($this->fields as $field) {
            if ($field instanceof Field) {
                $fields[] = $field;
            }
        }
        return $fields;
    }

    public function submitButton($label = 'Submit', $class = "btn-primary")
    {
        $button = Button::make()->withAttributes([
            'type'  => 'submit',
            'class' => 'btn ' . $class,
        ])->label($label);
        $this->content($button);
        return $button;
    }

    public function post($action, $method = null): static
    {
        if ($method) {
            $this->method = $method;
        }
        return $this->withAttributes(['action' => $action]);
    }

    public function put($action): static
    {
        return $this->post($action, 'put');
    }

    public function validate(): array
    {
        $rules = $this->getRules();
        return request()->validate($rules);
    }

    public function getFieldsFromContent($parent = null): array
    {
        $fields = [];
        if ($parent === null) {
            $parent = $this;
        }

        if ($parent instanceof Field) {
            $parent->form = $this;
            $fields[]     = $parent;
        } elseif ($parent instanceof Renderable) {
            if (method_exists($parent, 'content')) {
                $children = $parent->getContent();
                if (!empty($children)) {
                    $sub_fields = $this->getFields($children);
                    array_push($fields, ...$sub_fields);
                }
            }
        } elseif (is_array($parent)) {
            foreach ($parent as $item) {
                if (!empty($item)) {
                    $sub_fields = $this->getFields($item);
                    array_push($fields, ...$sub_fields);
                }
            }
        } else {
            dd($parent);
        }

        return $fields;
    }

    public function getRules($include_empty = true): array
    {
        $fields = $this->getFields();
        $rules  = [];
        foreach ($fields as $field) {
            /**
             * @var Field $field
             */
            $rule = $field->getRules() ?? [];
            if (!empty($rule) || $include_empty) {
                $rules[$field->getName()] = $rule;
            }
        }

        return $rules;
    }

    public function getDepends(): array
    {
        $fields  = $this->getFields();
        $depends = [];
        foreach ($fields as $field) {
            /**
             * @var Field $field
             */
            $depend = $field->dependsFields();
            if (!empty($depend)) {
                $depends[$field->getId()] = $depend;
            }
        }

        return $depends;
    }

    public function renderForm(): void
    {
        $this->fieldContext = [
            'label_position' => 'inline',
            'form'           => $this,
        ];
    }

}
