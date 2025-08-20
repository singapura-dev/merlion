<?php

namespace Merlion\Components\Table\BatchActions;

use Merlion\Components\Button;
use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Concerns\HasIcon;
use Merlion\Components\Containers\Container;
use Merlion\Components\Form\Form;
use Merlion\Components\Renderable;

class BatchAction extends Renderable
{
    use AsCell;
    use HasIcon;

    protected ?Form $form = null;

    public function handle()
    {
        // do something
        return back();
    }

    public function action($action, $method = 'post'): static
    {
        return $this->withAttributes(['data-batch-action' => $action, 'data-method' => $method]);
    }

    public function getForm()
    {
        return $this->form;
    }

    public function form($fields = []): static
    {
        if (empty($this->form)) {
            $this->form = Form::make();
            $this->form->content(
                Container::make(Button::make('submit', 'Submit'), 'footer')->class('mt-3'),
                'footer'
            );
        }

        if (!empty($fields)) {
            $this->form->fields($fields);
        }

        return $this;
    }

    public function confirm($title, $content = '', $type = 'danger')
    {
    }
}
