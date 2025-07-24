<?php

declare(strict_types=1);

namespace Merlion\Http\Controllers;

use Illuminate\Support\Str;
use Merlion\Components\Button;
use Merlion\Components\Card;
use Merlion\Components\Flex;
use Merlion\Components\Form\Errors;
use Merlion\Components\Form\Fields\Field;
use Merlion\Components\Form\Form;
use Merlion\Components\Grid\Displayers\Displayer;
use Merlion\Components\Grid\Grid;
use Merlion\Components\Pages\Crud\CreateButton;
use Merlion\Components\Pages\Crud\DeleteRowButton;
use Merlion\Components\Pages\Crud\EditRowButton;
use Merlion\Components\Pages\Crud\ViewRowButton;
use Merlion\Components\Renderable;
use Merlion\Components\Table\Columns\Column;
use Merlion\Components\Table\Filters;
use Merlion\Components\Table\Table;

abstract class CrudController
{
    protected string $model;
    protected string $route;
    protected string $label;
    protected string $lang;

    public function index()
    {
        admin()->title($this->getLabel());

        $card  = Card::make();
        $table = Table::make();

        // columns
        foreach ($this->columns() as $column) {
            if (is_string($column)) {
                $column = [
                    'name' => $column,
                ];
            }
            if (is_array($column)) {

                if (!($column['index'] ?? true)) {
                    continue;
                }

                if (empty($column['label'])) {
                    $column['label'] = $this->getFieldLabel($column['name']);
                }

                if (is_array($column)) {
                    $column = Column::column($column['type'] ?? 'text', $column);
                }
            }
            if ($column instanceof Column) {
                $table->columns($column);
            }
        }

        // filters
        $filters = $this->getFilters();
        $sorts   = $this->getSorts();
        if (!empty($filters) || !empty($sorts)) {
            $filter = Filters::make()->for($this->getModel());
            $filter->filters($filters);
            $filter->sorts($sorts);
            $card->header($filter);
        }

        // tools
        $tools = $this->getTools();
        if (!empty($tools)) {
            $card->header($tools);
        }

        $card->getHeader()->justifyContent('between');

        // actions
        $actions = [
            ViewRowButton::make(route: $this->route),
            EditRowButton::make(route: $this->route),
            DeleteRowButton::make(route: $this->route),
        ];

        $table->actions($actions);

        // paginates
        if (!empty($filter)) {
            if (request('per_page') == 'all') {
                $table->rows($filter->all());
            } else {
                $table->rows($filter->paginate((int)request('per_page')));
            }
        } else {
            $table->rows(app($this->getModel())->paginate((int)request('per_page')));
        }

        $card->body($table);
        $card->getBody()->class('p-0');
        return admin()->content($card)->render();
    }

    public function show(...$args)
    {
        $id    = end($args);
        $model = app($this->getModel())->findOrFail($id);

        admin()->title(__('merlion::base.detail'));
        admin()->back(admin()->route($this->route . '.index'));

        $grid = $this->getGrid();
        $grid->model($model);

        return admin()->content($grid)->render();
    }

    public function create()
    {
        admin()->title(__('merlion::base.create', ['label' => $this->getLabel()]));
        admin()->back('/admin/' . $this->route);
        $form = $this->getForm();
        $form->post(admin()->route($this->route . '.store'));
        return admin()->content($form)->render();
    }

    public function store()
    {
        $form      = $this->getForm();
        $validated = $form->validate();
        app($this->getModel())->create($validated);
        return back();
    }

    public function edit(...$args)
    {
        $id    = end($args);
        $model = app($this->getModel())->findOrFail($id);

        admin()->title(__('merlion::base.edit'))->back(admin()->route($this->route . '.index'));
        $form = $this->getForm();
        $form->model($model);
        $form->put(admin()->route($this->route . '.update', $id));
        return admin()->content($form)->render();
    }

    public function update(...$args)
    {
        $id        = end($args);
        $model     = app($this->getModel())->findOrFail($id);
        $form      = $this->getForm();
        $validated = $form->validate();
        $model->update($validated);

        admin()->success('Update successfully');
        return back();
    }

    public function destroy(...$args)
    {
        $id = end($args);
        app($this->getModel())->findOrFail($id)->delete();
        admin()->success('Delete successfully');
        if (request()->ajax()) {
            return response()->json([
                'status' => 'success',
                'action' => 'refresh',
            ]);
        }
        return back();
    }

    protected function getModel()
    {
        return $this->model;
    }

    protected function getLabel()
    {
        return $this->label ?? __($this->lang . '.label');
    }

    protected function getFieldLabel($name)
    {
        if (trans()->has($this->lang . '.' . $name)) {
            return trans($this->lang . '.' . $name);
        }
        return Str::headline($name);
    }

    protected function getForm(): Form
    {
        $form = Form::make($this->entities()['form'] ?? []);
        $card = Card::make();
        $card->body(Flex::make(Errors::make()->class('w-full'), $this->getFields())->wrap()->gap(3));
        $card->footer(Button::make()->primary()->label(__('merlion::base.create')));
        $form->content($card);
        return $form;
    }

    protected function getFields()
    {
        $fields = [];
        foreach ($this->fields() as $field) {
            if (is_string($field)) {
                $field = [
                    'type' => 'text',
                    'name' => $field,
                ];
            }

            if (is_array($field)) {
                if (empty($field['label'])) {
                    $field['label'] = $this->getFieldLabel($field['name']);
                }
                $field = Field::field($field['type'] ?? 'text', $field);
            }

            if ($field instanceof Field) {
                $fields[] = $field;
            }
        }
        return $fields;
    }

    protected function getTools()
    {
        $tools = [];
        foreach ($this->tools() ?? [] as $tool) {
            if (is_string($tool)) {
                switch ($tool) {
                    case 'create':
                        $tool = CreateButton::make(route: $this->route);
                        break;
                }
            }

            if ($tool instanceof Renderable) {
                $tools[] = $tool;
            }
        }

        return $tools;
    }

    protected function getFilters()
    {
        $filters = [];
        foreach ($this->filters() ?? [] as $filter) {
            if (is_string($filter)) {
                $filter = [
                    'type' => 'text',
                    'name' => $filter,
                ];
            }
            if (is_array($filter)) {
                if (empty($filter['label'])) {
                    $filter['label'] = $this->getFieldLabel($filter['name']);
                }
                $filter = Filters\Text::make($filter);
            }

            if ($filter instanceof Filters\Filter) {
                $filters[] = $filter;
            }
        }
        return $filters;
    }

    protected function getSorts()
    {
        $sorts = [];
        foreach ($this->sorts() ?? [] as $sort) {
            if (is_string($sort)) {
                $sort = [
                    'type' => 'text',
                    'name' => $sort,
                ];
            }
            if (is_array($sort)) {
                if (empty($sort['label'])) {
                    $sort['label'] = $this->getFieldLabel($sort['name']);
                }
                $sort = Filters\Sort::make($sort);
            }

            if ($sort instanceof Filters\Sort) {
                $sorts[] = $sort;
            }
        }
        return $sorts;
    }

    protected function getGrid()
    {
        $grid = Grid::make();
        $card = Card::make();

        $displayers = $this->getDisplayers();
        $flex       = Flex::make($displayers)->wrap()->gap(3);
        $card->body($flex);

        $grid->content($card);

        return $grid;
    }

    protected function getDisplayers()
    {
        $displayers = [];
        foreach ($this->displayers() as $displayer) {
            if (is_string($displayer)) {
                $displayer = [
                    'type' => 'text',
                    'name' => $displayer,
                ];
            }

            if (is_array($displayer)) {
                if (empty($displayer['label'])) {
                    $displayer['label'] = $this->getFieldLabel($displayer['name']);
                }
                $displayer = Displayer::displayer($displayer['type'] ?? 'text', $displayer);
            }

            if ($displayer instanceof Displayer) {
                $displayers[] = $displayer;
            }
        }
        return $displayers;
    }

    protected function fields()
    {
        return $this->entities()['fields'] ?? [];
    }

    protected function columns()
    {
        return $this->entities()['columns'] ?? [];
    }

    protected function tools()
    {
        return $this->entities()['tools'] ?? [];
    }

    protected function filters()
    {
        return $this->entities()['filters'] ?? [];
    }

    protected function sorts()
    {
        return $this->crud()['sorts'] ?? [];
    }

    protected function displayers()
    {
        return $this->crud()['displayers'] ?? [];
    }

    protected function entities()
    {
        return [];
    }

    protected function crud()
    {
        return array_merge($this->defaultEntities(), $this->entities());
    }

    protected function defaultEntities()
    {
        return [
            'table'      => [],
            'tools'      => [
                'create',
            ],
            'sorts'      => [],
            'actions'    => ['view', 'edit', 'delete'], // view | edit | delete
            'filters'    => [],
            'form'       => [],
            'columns'    => [],
            'fields'     => [],
            'grid'       => [],
            'displayers' => [],
        ];
    }
}
