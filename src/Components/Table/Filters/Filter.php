<?php

declare(strict_types=1);

namespace Merlion\Components\Table\Filters;

use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Renderable;
use Spatie\QueryBuilder\Enums\FilterOperator;

abstract class Filter extends Renderable
{
    use AsCell;

    public static array $filters = [
        'text'   => Text::class,
        'select' => Select::class,
    ];

    protected string $filterType = 'partial';
    protected ?FilterOperator $operator = null;

    public static function generate($cell): static
    {
        if (is_string($cell)) {
            $cell = [
                'name' => $cell,
                'type' => 'text',
            ];
        }

        if (is_array($cell)) {
            $cell_class = static::$filters[$cell['type'] ?? 'text'] ?? Text::class;
            unset($cell['type']);
            $cell = $cell_class::make($cell);
        }

        if ($cell instanceof Filter) {
            return $cell;
        }
    }

    public function exact(): static
    {
        $this->filterType = 'exact';
        return $this;
    }

    public function partial(): static
    {
        $this->filterType = 'partial';
        return $this;
    }

    public function scope(): static
    {
        $this->filterType = 'scope';
        return $this;
    }

    public function operator($operator): static
    {
        $this->filterType = 'operator';
        $this->operator   = $operator;
        return $this;
    }

    public function getFilterType(): string
    {
        return $this->filterType;
    }

    public function getOperator(): ?FilterOperator
    {
        if (empty($this->operator)) {
            return FilterOperator::EQUAL;
        }
        return $this->operator;
    }

    public function getValue(): mixed
    {
        return request('filter.' . $this->getName());
    }

    public function getFilterName(): string
    {
        return 'filter[' . $this->getName() . ']';
    }
}
