<?php
declare(strict_types=1);

namespace Merlion\Http\Controllers\Concerns;

use Merlion\Components\Button;
use Merlion\Components\Containers\Card;
use Merlion\Components\Form\Fields\Text;
use Merlion\Components\Form\Form;
use Merlion\Components\Table\BatchActions;
use Merlion\Components\Table\Columns\Actions;
use Merlion\Components\Table\Columns\Column;
use Merlion\Components\Table\Columns\Select;
use Merlion\Components\Table\Filters;
use Merlion\Components\Table\Table;

/**
 * @mixin AsCurdController
 */
trait HasIndex
{
    public static int $perPage = 10;
    protected Filters $filter;
    protected Table $table;
    protected mixed $builder;
    protected Card $indexCard;

    public function index(...$args)
    {
        $this->authorize('viewAny', $this->getModel());

        $this->callMethods('beforeIndex', ...$args);

        $this->indexCard = Card::make();

        $this->table = $this->table(...$args);

        $filters      = $this->filters();
        $searches     = $this->searches();
        $sorts        = $this->sorts();
        $builder      = $this->getQueryBuilder();
        $batchActions = $this->getBatchActions();

        if (!empty($filters) || !empty($sorts) || !empty($batchActions) || !empty($searches)) {
            if (!empty($searches)) {
                $search_form = Form::make()->class('me-2')->method('get');
                $search_form->field(
                    Text::make('search')->value(request('search'))
                        ->content('<span class="input-icon-addon"><i class="ti ti-search"></i></span>', 'after')
                        ->class('input-icon', 'wrapper')
                        ->noLabel()
                        ->placeholder(__('merlion::table.search') . '...')
                );
                $this->indexCard->header($search_form);
                $builder = $this->applyQuickSearch($builder);
            }

            $this->filter = Filters::make()->for($builder);
            $this->filter->filters($filters);
            $this->filter->sorts($sorts);
            $this->indexCard->header($this->filter);

            if (!empty($batchActions)) {
                $this->table->selectable(true);
                $batchActionDropdown = BatchActions::make()
                    ->table($this->table)
                    ->label(__('merlion::base.batch_actions'))
                    ->icon('ti ti-bolt me-1')
                    ->class('ms-3')
                    ->content($batchActions);
                $this->indexCard->header($batchActionDropdown);
            }
        }

        admin()->content($this->getIndexTools(), 'header');

        $actions = $this->getRowActions();

        if (!empty($actions)) {
            $this->table->column(Actions::make()->class('float-end',
                'wrapper')->icon('ti ti-dots')->dropdown()->actions($actions));
        }

        if (request('trash')) {
            $models = $builder->onlyTrashed()->get();
            $this->table->models($models);
        } else {
            if (!empty($this->filter)) {
                if (request('per_page') == 'all') {
                    $this->table->models($this->filter->all());
                } else {
                    $models = $this->filter->paginate((int)request('per_page', static::$perPage));
                    $this->table->models($models);
                    $this->indexCard->footer($models->links());
                }
            } else {
                $this->table->models($builder->paginate((int)request('per_page', static::$perPage)));
            }
        }

        $this->indexCard->content($this->table);

        admin()->pageTitle($this->getLabelPlural())
            ->title($this->getLabelPlural())
            ->content($this->indexCard);

        $this->builder = $builder;
        $this->callMethods('afterIndex', ...$args);
        return admin()->render();
    }

    protected function table()
    {
        $table   = Table::make();
        $columns = $this->columns();
        $table->columns($columns);
        return $table;
    }

    protected function columns(): array
    {
        $schemas = $this->schemas();
        $columns = [];
        foreach ($schemas as $name => $schema) {

            if (is_string($schema)) {
                $schema = [
                    'type' => 'text',
                    'name' => $schema,
                ];
            }

            if (is_array($schema)) {
                if (is_string($name) && !isset($schema['name'])) {
                    $schema['name'] = $name;
                }

                if (!array_key_exists('label', $schema)) {
                    $schema['label'] = $this->lang($schema['name']);
                }

                if (isset($schema['show_index']) && !$schema['show_index']) {
                    continue;
                }
            }

            $column = Column::generate($schema);
            if ($column->shouldShow('index')) {
                $columns[] = $column;
            }
        }
        return $columns;
    }

    protected function filters(): array
    {
        $columns = $this->columns();
        $filters = [];
        foreach ($columns as $column) {
            if (!($column instanceof Column)) {
                continue;
            }
            if ($column->getFilterable()) {
                if ($filter = $column->getFilter()) {
                    $filter  = is_array($filter) ? $filter : [$filter];
                    $filters = [
                        ...$filters,
                        ...$filter,
                    ];
                } else {
                    $type = get_class($column) === Select::class ? "select" : "text";
                    $data = [
                        'name'  => $column->getName(),
                        'label' => $column->getLabel(),
                        'type'  => $type,
                    ];
                    if ($type == 'select') {
                        $data['options'] = $column->getOptions();
                    }
                    $filters[] = Filters\Filter::generate($data);
                }
            }
        }
        return $filters;
    }

    protected function sorts(): array
    {
        $columns = $this->columns();
        $sorts   = [];
        foreach ($columns as $column) {
            if (!($column instanceof Column)) {
                continue;
            }
            if ($column->getSortable()) {
                if ($sort = $column->getSort()) {
                    $sort  = is_array($sort) ? $sort : [$sort];
                    $sorts = [
                        ...$sorts,
                        ...$sort,
                    ];
                } else {
                    $sorts[] = Filters\Sort::make($column->getName(),
                        $column->getLabel() . ' ' . __('merlion::base.sort_asc'));
                    $sorts[] = Filters\Sort::make('-' . $column->getName(),
                        $column->getLabel() . ' ' . __('merlion::base.sort_desc'));
                }
            }
        }
        return $sorts;
    }

    protected function getBatchActions(): array
    {
        return [];
    }

    protected function getIndexTools(): array
    {
        $tools = [];
        if ($this->can('create', $this->getModel())) {
            $tools[] = Button::make()->primary()->link($this->route('create'))->icon('ti ti-plus me-1')->label(__('merlion::base.create'));
        }
        return $tools;
    }

    protected function getRowActions(): array
    {
        $actions = [];

        $actions[] = Actions\Action::make('view')
            ->class('btn-sm btn-ghost')->label('<i class="ti ti-eye"></i> ' . __('merlion::base.view'))
            ->shouldRenderUsing(function ($action) {
                return $this->can('view', $action->getModel());
            })
            ->rendering(function ($action) {
                $action->withAttributes(['href' => $this->route('show', $action->getModel()->getKey())]);
            });

        $actions[] = Actions\Action::make('edit')->class('btn-sm btn-ghost')->label('<i class="ti ti-edit"></i> ' . __('merlion::base.edit'))
            ->shouldRenderUsing(function ($action) {
                $model = $action->getModel();
                return $this->can('update', $model);
            })
            ->rendering(function ($action) {
                $action->withAttributes(['href' => $this->route('edit', $action->getModel()->getKey())]);
            });

        $actions[] = Actions\Action::make('delete')->class('btn-sm btn-ghost-danger text-danger')
            ->label('<i class="ti ti-trash"></i> ' . __('merlion::base.delete'))
            ->shouldRenderUsing(function ($action) {
                $model = $action->getModel();
                if ($model->deleted_at) {
                    return false;
                }
                return $this->can('delete', $model);
            })
            ->rendering(function ($action) {
                $action->withAttributes([
                    'data-method'              => 'delete',
                    'data-confirm'             => __('merlion::table.delete_confirm.title'),
                    'data-confirm-text'        => __('merlion::table.delete_confirm.text'),
                    'data-cancel-button-text'  => __('merlion::table.delete_confirm.cancel'),
                    'data-confirm-button-text' => __('merlion::table.delete_confirm.delete'),
                    'data-action'              => $this->route('destroy', $action->getModel()->getKey()),
                ]);
            });

        if ($this->canSoftDelete()) {
            $actions[] = Actions\Action::make('restore')->class('btn-sm btn-ghost-success text-success')
                ->label('<i class="ti ti-restore"></i> ' . __('merlion::base.restore'))
                ->shouldRenderUsing(function ($action) {
                    $model = $action->getModel();
                    return $model->deleted_at && $this->can('restore', $model);
                })
                ->rendering(function ($action) {
                    $action->withAttributes([
                        'data-method'  => 'put',
                        'data-confirm' => 'Are you sure?',
                        'data-action'  => $this->route('restore', $action->getModel()->getKey()),
                    ]);
                });
        }
        return $actions;
    }

    protected function searches(): array
    {
        return [];
    }

    protected function applyQuickSearch($builder)
    {
        $searches = $this->searches();
        $keyword  = request('search');
        $builder->where(function ($query) use ($searches, $keyword) {
            foreach ($searches as $search) {
                $query->orWhere($search, 'like', "%" . $keyword . "%");
            }
        });
        return $builder;
    }

}

