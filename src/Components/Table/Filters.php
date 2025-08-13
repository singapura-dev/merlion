<?php

declare(strict_types=1);

namespace Merlion\Components\Table;

use Merlion\Components\Renderable;
use Merlion\Components\Table\Filters\Filter;
use Merlion\Components\Table\Filters\Sort;
use Merlion\Components\Table\Filters\Text;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Query builder
 */
class Filters extends Renderable
{

    public mixed $perPages = [5, 10, 15, 50, 100];
    public mixed $allowAll = true;
    protected QueryBuilder $builder;
    protected array $filters = [];
    protected array $sorts = [];

    public function inline(): static
    {
        $this->view = 'merlion::table.filters_inline';
        return $this;
    }

    public function for($model): static
    {
        $this->builder = QueryBuilder::for($model);
        return $this;
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null, $total = null)
    {
        $this->buildFilter();
        return $this->builder->paginate($perPage, $columns, $pageName, $page, $total)
            ->appends(request()->query());
    }

    protected function buildFilter()
    {
        $filters = $this->getFilters();
        $allowed_filters = [];
        foreach ($filters as $filter) {
            /**
             * @var Filter $filter
             */
            $filter_type = $filter->getFilterType();
            switch ($filter_type) {
                case 'partial';
                    $allowed_filters[] = $filter->getName();
                    break;
                case 'exact':
                    $allowed_filters[] = AllowedFilter::exact($filter->getName());
                    break;
                case 'scope':
                    $allowed_filters[] = AllowedFilter::scope($filter->getName());
                    break;
                case 'operator':
                    $allowed_filters[] = AllowedFilter::operator($filter->getName(), $filter->getOperator());
            }
        }
        $this->builder->allowedFilters($allowed_filters);

        $allowed_sorts = [];
        foreach ($this->sorts as $sort) {
            if (is_string($sort)) {
                $allowed_sorts[] = $sort;
            }
            if ($sort instanceof Sort) {
                $allowed_sorts[] = $sort->getName();
            }
        }
        $this->builder->allowedSorts($allowed_sorts);
        return $this;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function all()
    {
        $this->buildFilter();
        return $this->builder->get();
    }

    public function filters($filters)
    {
        $filters = is_array($filters) ? $filters : func_get_args();
        foreach ($filters as $filter) {
            if (is_string($filter)) {
                $filter = Text::make($filter);
            }
            if ($filter instanceof Filter) {
                $this->filters[] = $filter;
            }
        }
        return $this;
    }

    public function sorts($sorts)
    {
        $this->sorts = $sorts;
        return $this;
    }

    public function getSorts(): array
    {
        return $this->sorts;
    }
}
