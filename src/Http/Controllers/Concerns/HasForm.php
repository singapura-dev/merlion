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
    public function store(...$args)
    {
        $this->authorize('create', $this->getModel());
        $form      = $this->form();
        $validated = $form->validate();
        app($this->getModel())->create($validated);
        admin()->success(__('merlion::base.action_performace_success'));
        return redirect($this->route('index'));
    }

    protected function form($model = null)
    {
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

    public function update(...$args)
    {
        $id    = Arr::last($args);
        $model = app($this->getModel())->findOrFail($id);

        $this->authorize('update', $model);

        $form      = $this->form($model);
        $validated = $form->validate();
        $model->update($validated);
        admin()->success(__('merlion::base.action_performace_success'));
        return redirect($this->route('index'));
    }
}
