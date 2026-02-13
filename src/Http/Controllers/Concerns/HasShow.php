<?php
declare(strict_types=1);

namespace Merlion\Http\Controllers\Concerns;

use Illuminate\Support\Arr;
use Merlion\Components\Alert;
use Merlion\Components\Containers\Card;
use Merlion\Components\Renderable;
use Merlion\Components\Show\Grid\Grid;
use Merlion\Components\Show\Show;

/**
 * @mixin AsCurdController
 */
trait HasShow
{
    public function show(...$args)
    {
        $this->callMethods('beforeShow', ...$args);

        $id = Arr::last($args);
        $model = $this->findById($id);
        $this->authorize('view', $model);

        $this->current_model = $model;

        if ($model->deleted_at) {
            admin()->content(Alert::make()
                ->closable(false)
                ->content(__('merlion::base.record_deleted_at',
                    ['deleted_at' => $model->deleted_at]))->icon('ti ti-alert-triangle alert-icon icon'));
        }

        $card = Card::make();
        $grid = $this->grid($model);
        $card->body($grid);

        $tools = $this->getShowTools($model);
        if (!empty($tools)) {
            admin()->content($tools, 'header');
        }
        admin()->backUrl($this->route('index'))
            ->pageTitle(__('merlion::base.view') . ' ' . $this->getLabel())
            ->title(__('merlion::base.view') . ' ' . $this->getLabel())
            ->content($card);

        $this->callMethods('afterShow', $model);

        return admin()->render();
    }

    protected function grid($model): Renderable
    {
        $grid  = Show::make()->model($model);
        $grids = $this->grids($model);
        $grid->content($grids);
        return $grid;
    }

    protected function grids($model): array
    {
        $grids   = [];
        $schemas = $this->schemas();
        foreach ($schemas as $name => $schema) {
            if (is_string($schema)) {
                $schema = [
                    'name' => $schema,
                ];
            }
            if (is_array($schema)) {
                if (empty($schema['name']) && is_string($name)) {
                    $schema['name'] = $name;
                }
                if (isset($schema['show_detail']) && !$schema['show_detail']) {
                    continue;
                }
                if (!isset($schema['label'])) {
                    $schema['label'] = $this->lang($schema['name']);
                }
            }
            $schema = Grid::generate($schema);
            if ($schema->shouldShow('show')) {
                $grids[] = $schema;
            }
        }
        return $grids;
    }

    protected function getShowTools($model): array
    {
        return [];
    }
}
