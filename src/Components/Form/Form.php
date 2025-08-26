<?php
declare(strict_types=1);

namespace Merlion\Components\Form;

use Merlion\Components\Concerns\HasAction;
use Merlion\Components\Concerns\HasContent;
use Merlion\Components\Concerns\HasModel;
use Merlion\Components\Containers\Flex;
use Merlion\Components\Form\Fields\Field;
use Merlion\Components\Renderable;

class Form extends Renderable
{
    use HasAction;
    use HasContent;
    use HasModel;

    public function __construct(...$args)
    {
        parent::__construct($args);

        $first = $args[0] ?? null;
        if (is_array($first) && $first[0] instanceof Renderable) {
            $this->fields($first);
        }
    }

    public function fields($fields): static
    {
        $container = $this->getContainer();
        $container->content($fields);
        return $this;
    }

    public function getContainer()
    {
        $content = $this->getContent();
        if (empty($content)) {
            $container = Flex::make()->wrap()->gap(3)->alignItems('start');
            $this->content($container);
        } else {
            $container = $content[0];
        }

        return $container;
    }

    public function field($field): static
    {
        $field = Field::generate($field);
        $this->fields($field);
        return $this;
    }

    public function validate(): array
    {
        $this->build();
        $rules = $this->getRules();
        return request()->validate($rules);
    }

    public function getRules($include_empty = true): array
    {
        $fields = $this->getFlatFields();
        $rules = [];
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

    public function getFlatFields($parent = null): array
    {
        $fields = [];
        if (empty($parent)) {
            $parent = $this;
        }

        if (is_array($parent)) {
            foreach ($parent as $field) {
                $sub_fields = $this->getFlatFields($field);
                array_push($fields, ...$sub_fields);
            }
            return $fields;
        }

        if ($parent instanceof Field) {
            $fields[] = $parent;
            return $fields;
        }

        if (method_exists($parent, 'getContent')) {
            $sub_fields = $this->getFlatFields($parent->getContent());
            array_push($fields, ...$sub_fields);
        }

        return $fields;
    }
}
