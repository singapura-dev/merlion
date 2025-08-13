<?php

declare(strict_types=1);

namespace Merlion\Components\Containers;

class Card extends Container
{
    public static array $defaultClass = [
        'header' => 'card-header',
        'body' => 'card-body',
        'footer' => 'card-footer',
    ];

    public function registerCard(): void
    {
        $this->element('div');
        $this->class('card');
    }

    public function header($content): static
    {
        return $this->pushContentTo('header', $content);
    }

    protected function pushContentTo($position, $content): static
    {
        $container = $this->getContent($position);
        if (empty($container)) {
            $container = Container::make();
            if (!empty(static::$defaultClass[$position])) {
                $container->class(static::$defaultClass[$position]);
            }
            $this->content($container, $position);
        }
        $container->content($content);
        return $this;
    }

    public function body($content): static
    {
        return $this->pushContentTo('body', $content);
    }

    public function footer($content): Container
    {
        return $this->pushContentTo('footer', $content);
    }
}
