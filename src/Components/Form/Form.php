<?php

declare(strict_types=1);

namespace Merlion\Components\Form;

use Merlion\Components\Button;
use Merlion\Components\Concerns\AsContainer;
use Merlion\Components\Form\Fields\Field;
use Merlion\Components\Renderable;

class Form extends Renderable
{
    use AsContainer;

    protected string $view = 'merlion::form.form';

    protected mixed $model = null;

    public bool $hideLabel = false;

    public function submitButton($label = 'Submit', $class = "btn-primary")
    {
        $button = Button::make()->withAttributes([
            'type'  => 'submit',
            'class' => 'btn ' . $class,
        ])->content($label);
        $this->content($button);
        return $button;
    }

    public function post($action): static
    {
        return $this->withAttributes(['method' => 'post'])
            ->withAttributes(['action' => $action]);
    }

    public function model($model)
    {
        $this->model = $model;
        return $this;
    }

    public function getModel(): mixed
    {
        return evaluate($this->model ?? null, $this);
    }

    public function getFields($parent = null): array
    {
        $fields = [];

        if ($parent === null) {
            $parent = $this;
        }

        if ($parent instanceof Field) {
            $fields[] = $parent;
        } elseif ($parent instanceof Renderable) {
            $children   = $parent->getContent();
            $sub_fields = $this->getFields($children);
            array_push($fields, ...$sub_fields);
        } elseif (is_array($parent)) {
            foreach ($parent as $item) {
                if (!empty($item)) {
                    $sub_fields = $this->getFields($item);
                    array_push($fields, ...$sub_fields);
                }
            }
        }

        return $fields;
    }

    public function getRules()
    {
        $fields = $this->getFields();
        $rules  = [];
        foreach ($fields as $field) {
            /**
             * @var Field $field
             */
            $rule = $field->getRules();
            if (!empty($rule)) {
                $rules[$field->getName()] = $rule;
            }
        }

        return $rules;
    }

    public function getDepends()
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

}
