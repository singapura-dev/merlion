<?php

declare(strict_types=1);

namespace Merlion\Http\Controllers;

use Merlion\Components\Table\Columns\Column;
use Merlion\Components\Table\Columns\Text;
use Merlion\Components\Table\Table;

/**
 * @method array columns() Get all fields
 */
abstract class CrudController
{
    protected string $model;
    protected string $route;

    public function index()
    {
        $table = Table::make();
        if (method_exists($this, 'columns')) {
            $columns = $this->columns();
        } elseif (method_exists($this, 'crud')) {
            $columns = $this->crud();
        }
        if (!empty($columns)) {
            foreach ($columns as $column) {
                if (is_string($column)) {
                    $column = [
                        'name' => $column,
                    ];
                }
                if (is_array($column)) {
                    if ($column['hide_index'] ?? false) {
                        continue;
                    }
                    switch ($column['type'] ?? 'text') {
                        case 'text':
                        default:
                            $column = Text::make($column['name'], $column['label'] ?? $column['name']);
                    }
                    if ($column instanceof Column) {
                        $table->columns($column);
                    }
                }
            }
        }
        $table->rows(app($this->getModel())->paginate());
        return admin()->content($table)->render();
    }

    public function create()
    {
        return admin()->render();
    }

    public function edit(...$args)
    {
        return admin()->render();
    }

    public function store()
    {
    }

    public function update(...$args)
    {
    }

    protected function getModel()
    {
        return $this->model;
    }

    protected function entities()
    {
        return [
            [
                'name'       => 'name',
                'label'      => '姓名',
                'filterable' => false,
                'sortable'   => false,
                'index'      => true,
                'create'     => true,
                'edit'       => true,
                'show'       => true,
            ],
        ];
    }
}
