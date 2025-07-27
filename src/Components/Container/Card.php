<?php

declare(strict_types=1);

namespace Merlion\Components\Container;

class Card extends Container
{
    public $view = 'merlion::layouts.card';

    protected Flex $header;
    protected Container $body;
    protected Container $footer;

    public function header($content): static
    {
        if (empty($this->header)) {
            $this->header = Flex::make()->class('card-header');
            $this->content($this->header);
        }
        $this->header->content($content);
        return $this;
    }

    public function body($content): static
    {
        if (empty($this->body)) {
            $this->body = Container::make()->class('card-body');
            $this->content($this->body);
        }
        $this->body->content($content);
        return $this;
    }

    public function footer($content): static
    {
        if (empty($this->footer)) {
            $this->footer = Container::make()->class('card-footer');
            $this->content($this->footer);
        }
        $this->footer->content($content);
        return $this;
    }
}
