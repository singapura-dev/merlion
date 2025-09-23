<?php
declare(strict_types=1);

namespace Merlion\Http\Controllers\Concerns;

use Merlion\Components\Button;
use Merlion\Components\Containers\Card;
use Merlion\Components\Table\BatchActions;
use Merlion\Components\Table\Columns\Actions;
use Merlion\Components\Table\Columns\Column;
use Merlion\Components\Table\Filters;
use tinker\packages\singapura\merlion\src\Components\Table\Table;

/**
 * @mixin AsCurdController
 */
trait HasIndex
{
    public static int $perPage = 10;
    protected Filters $filter;
    protected Table $table;
    protected Card $indexCard;

    public function index(...$args)
    {
        $this->authorize('viewAny', $this->getModel());

        $this->callMethods('beforeIndex', ...$args);

        $this->indexCard = Card::make();

        $this->table = $this->table(...$args);

        $filters      = $this->getFilters();
        $sorts        = $this->getSorts();
        $builder      = $this->getQueryBuilder();
        $batchActions = $this->getBatchActions();

        if (!empty($filters) || !empty($sorts) || !empty($batchActions)) {
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
            $this->table->column(Actions::make()->icon('ti ti-dots')->dropdown()->actions($actions));
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

                if (!isset($schema['label'])) {
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

    protected function getFilters(): array
    {
        $schemas = $this->schemas();
        $filters = [];
        foreach ($schemas as $name => $schema) {
            if (is_array($schema)) {
                if (empty($schema['name']) && is_string($name)) {
                    $schema['name'] = $name;
                }

                if ($schema['filterable'] ?? false) {
                    if (empty($schema['label'])) {
                        $schema['label'] = $this->lang($schema['name']);
                    }
                    $filters[] = Filters\Filter::generate($schema);
                }
            }
        }
        return $filters;
    }

    protected function getSorts(): array
    {
        $schemas = $this->schemas();
        $sorts   = [];
        foreach ($schemas as $name => $schema) {
            if (is_array($schema)) {
                if (empty($schema['name']) && is_string($name)) {
                    $schema['name'] = $name;
                }
                if (!empty($schema['sortable'] ?? null)) {
                    if (is_array($schema['sortable'])) {
                        foreach ($schema['sortable'] as $sort_name => $sort) {

                            if (is_string($sort)) {
                                $sort = [
                                    'name'  => $sort_name,
                                    'label' => $sort,
                                ];
                            }

                            if (is_array($sort)) {
                                if (empty($sort['name'])) {
                                    $sort['name'] = $sort_name ?? $name;
                                }

                                $sort = Filters\Sort::make($sort);
                            }

                            if ($sort instanceof Filters\Sort) {
                                $sorts[] = $sort;
                            }
                        }
                        continue;
                    }
                    $field   = $schema['sortable'] === 'desc' ? ('-' . $schema['name']) : $schema['name'];
                    $sorts[] = Filters\Sort::make($field, $schema['label'] ?? $this->lang($schema['name']));
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
                    'data-method'  => 'delete',
                    'data-confirm' => 'Are you sure?',
                    'data-action'  => $this->route('destroy', $action->getModel()->getKey()),
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

}

