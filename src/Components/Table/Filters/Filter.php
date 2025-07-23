<?php

declare(strict_types=1);

namespace Merlion\Components\Table\Filters;

use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Renderable;
use Spatie\QueryBuilder\Enums\FilterOperator;

abstract class Filter extends Renderable
{
    use AsCell;

    protected string $filterType = 'partial'; // partial | exact | operator | scope

    protected ?FilterOperator $operator = null;

    public function exact()
    {
        $this->filterType = 'exact';
        return $this;
    }

    public function partial()
    {
        $this->filterType = 'partial';
        return $this;
    }

    public function scope()
    {
        $this->filterType = 'scope';
        return $this;
    }

    public function operator($operator)
    {
        $this->filterType = 'operator';
        $this->operator   = $operator;
        return $this;
    }

    public function getFilterType()
    {
        return $this->filterType;
    }

    public function getOperator()
    {
        if (empty($this->operator)) {
            return FilterOperator::EQUAL;
        }
        return $this->operator;
    }

    public function getValue()
    {
        return request('filter.' . $this->getName());
    }

    public function getFilterName()
    {
        return 'filter[' . $this->getName() . ']';
    }
}
