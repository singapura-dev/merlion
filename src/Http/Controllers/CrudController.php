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
use Merlion\Components\Infolist\Entry\Entry;
use Merlion\Components\Infolist\Infolist;
use Merlion\Components\Layouts\Admin;
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
                    $column = Column::generate($column['type'] ?? 'text', $column);
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
            admin()->content($tools, Admin::POSITION_HEADER_RIGHT);
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

        $infolist = $this->getInfolist();
        $infolist->model($model);

        return admin()->content($infolist)->render();
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
        $form = Form::make($this->crud()['form'] ?? []);
        $card = Card::make();
        $card->body(Flex::make()->content(Errors::make()->class('w-full'), $this->getFields())->wrap()->gap(3));
        $card->footer(Button::make()->primary()->label(__('merlion::base.save')));
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

    protected function getInfolist()
    {
        $infolist = Infolist::make();
        $card     = Card::make();

        $entries = $this->getEntries();
        $flex    = Flex::make()->content($entries)->wrap()->gap(3);
        $card->body($flex);

        $infolist->content($card);

        return $infolist;
    }

    protected function getEntries()
    {
        $schemas = [];
        foreach ($this->entries() as $schema) {
            if (is_string($schema)) {
                $schema = [
                    'type' => 'text',
                    'name' => $schema,
                ];
            }

            if (is_array($schema)) {
                if (empty($schema['label'])) {
                    $schema['label'] = $this->getFieldLabel($schema['name']);
                }
                $schema = Entry::generate($displayer['type'] ?? 'text', $schema);
            }

            if ($schema instanceof Entry) {
                $schemas[] = $schema;
            }
        }
        return $schemas;
    }

    protected function fields()
    {
        return $this->crud()['fields'] ?? [];
    }

    protected function columns()
    {
        return $this->crud()['columns'] ?? [];
    }

    protected function tools()
    {
        return $this->crud()['tools'] ?? [];
    }

    protected function filters()
    {
        return $this->crud()['filters'] ?? [];
    }

    protected function sorts()
    {
        return $this->crud()['sorts'] ?? [];
    }

    protected function entries()
    {
        return $this->crud()['entries'] ?? [];
    }

    protected function schemas()
    {
        return [];
    }

    protected function crud()
    {
        return array_merge($this->defaultSchemas(), $this->schemas());
    }

    protected function defaultSchemas()
    {
        return [
            'table'   => [],
            'tools'   => [
                'create',
            ],
            'sorts'   => [],
            'actions' => ['view', 'edit', 'delete'], // view | edit | delete
            'filters' => [],
            'form'    => [],
            'columns' => [],
            'fields'  => [],
            'grid'    => [],
            'entries' => [],
        ];
    }
}
