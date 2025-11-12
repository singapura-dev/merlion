<?php
declare(strict_types=1);

namespace Merlion\Http\Controllers\Concerns;

use Illuminate\Support\Arr;
use Merlion\Components\Button;
use Merlion\Components\Containers\Card;
use Merlion\Components\Form\Fields\Field;
use Merlion\Components\Form\Form;

/**
 * @mixin AsCurdController
 */
trait HasForm
{

    public function create(...$args)
    {
        $this->authorize('create', $this->getModel());
        $card = Card::make();
        $form = $this->form();
        $form->withAttributes(['action' => $this->route('store')]);
        $form->content(Button::make()
            ->class('mt-3')
            ->primary()
            ->label(__('merlion::base.submit')));
        $card->body($form);
        admin()->backUrl($this->route('index'))
            ->pageTitle(__('merlion::base.create') . ' ' . $this->getLabel())
            ->title(__('merlion::base.create') . ' ' . $this->getLabel())
            ->content($card);
        return admin()->render();
    }

    public function edit(...$args)
    {
        $id    = Arr::last($args);
        $model = app($this->getModel())->findOrFail($id);

        $this->current_model = $model;

        $this->authorize('update', $model);

        $card = Card::make();
        $form = $this->form($model);
        $form->model($model);
        $form->put($this->route('update', $id));
        $form->content(Button::make()->primary()->class('mt-3')->label(__('merlion::base.submit')));

        $card->body($form);

        admin()->backUrl($this->route('index'))
            ->pageTitle(__('merlion::base.edit') . ' ' . $this->getLabel())
            ->title(__('merlion::base.edit') . ' ' . $this->getLabel())->content($card);

        return admin()->render();
    }

    public function store(...$args)
    {
        if (request('id')) {
            $args[] = request('id');
            return $this->update(...$args);
        }
        $this->authorize('create', $this->getModel());
        $form = $this->form();
        $this->createOrUpdate($form);

        admin()->success(__('merlion::base.action_performace_success'));
        return redirect(request('redirect', $this->route('index')));
    }

    public function update(...$args)
    {
        $id    = Arr::last($args);
        $model = app($this->getModel())->findOrFail($id);

        $this->current_model = $model;
        $this->authorize('update', $model);

        $form = $this->form($model);
        $this->createOrUpdate($form);

        admin()->success(__('merlion::base.action_performace_success'));
        return redirect(request('redirect', $this->route('index')));
    }

    protected function createOrUpdate(Form $form)
    {
        $model = $form->getModel();
        $form->validate();

        if (is_string($model) || empty($model->getKey())) {
            $model = new $model;
        }
        $fields = $form->getFlatFields();
        foreach ($fields as $field) {
            if ($field->getRelationship()) {
                continue;
            }
            $field->save($model);
        }

        $model->save();

        foreach ($fields as $field) {
            if (!$field->getRelationship()) {
                continue;
            }
            $field->saveRelationship($model);
        }
    }

    protected function form($model = null)
    {
        $model  = $model ?: app($this->getModel());
        $form   = Form::make()->model($model);
        $fields = $this->fields($model);
        $form->fields($fields);
        return $form;
    }

    protected function fields($model = null): array
    {
        $action  = $model ? 'edit' : 'create';
        $fields  = [];
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

                if (isset($schema['show_' . $action]) && !$schema['show_' . $action]) {
                    continue;
                }
                if (!isset($schema['label'])) {
                    $schema['label'] = $this->lang($schema['name']);
                }
            }
            $field = Field::generate($schema);
            if ($field->shouldShow($action)) {
                $fields[] = $field;
            }
        }
        return $fields;
    }
}
