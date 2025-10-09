<?php
declare(strict_types=1);

namespace Merlion\Components;

use Illuminate\Support\Str;
use Merlion\Components\Concerns\Admin\HasAssets;
use Merlion\Components\Concerns\HasId;

class Renderable extends Element
{
    use HasId;
    use HasAssets;

    public mixed $parent = null;
    protected mixed $view = null;
    protected mixed $display = null;
    protected bool $built = false;
    protected array $callbacks = [];
    protected mixed $shouldRenderUsing = null;

    public function __construct(...$args)
    {
        $namedParameter = true;

        foreach ($args as $key => $value) {
            if ($key === 0) {
                $namedParameter = false;
                if (count($args) === 1 && is_callable($args[0] ?? null)) {
                    $this->addHook('registering', $args[0]);
                    break;
                }
                if (is_array($args[0] ?? null)) {
                    $this->configureFromArray($args[0]);
                    break;
                }
            }
        }

        if ($namedParameter) {
            $this->configureFromArray($args);
        }

        $this->callMethods('register');

        static::callStaticHooks('registering', $this);

        $this->callHooks('registering', $this);
    }

    protected function configureFromArray($config): void
    {
        foreach ($config as $_key => $_value) {
            if (is_string($_key)) {
                if (Str::startsWith($_key, 'attributes')) {
                    $position = Str::after($_key, 'attributes_') ?? null;
                    $position = $position == 'attributes' ? null : $position;
                    $this->withAttributes($_value, $position);
                } elseif (Str::startsWith($_key, 'class')) {
                    $position = Str::after($_key, 'class_') ?? null;
                    $position = $position == 'class' ? null : $position;
                    $this->class($_value, $position);
                } elseif (public_property_exists($this, $_key) || public_method_exists($this, $_key)) {
                    if ('addHook' === $_key) {
                        $this->addHook($_value[0], $_value[1]);
                    } else {
                        $this->{$_key}($_value);
                    }
                } else {
                    $this->context($_key, $_value);
                }
            }
        }
    }

    public function shouldRenderUsing($callback): static
    {
        $this->shouldRenderUsing = $callback;
        return $this;
    }

    public function display($display): static
    {
        $this->display = $display;
        return $this;
    }

    public function parent($parent): static
    {
        $this->parent = $parent;
        return $this;
    }

    public function building($callback): static
    {
        $this->addHook('building', $callback);
        return $this;
    }

    public function registering($callback): static
    {
        $this->addHook('registering', $callback);
        return $this;
    }

    public function rendering($callback): static
    {
        $this->addHook('rendering', $callback);
        return $this;
    }

    public function render(): mixed
    {
        $this->id = $this->getId();
        $this->build();
        $this->callHooks('rendering', $this);
        $this->callMethods('render', $this);
        $data = array_merge(
            [
                'id'         => $this->getId(),
                'attributes' => $this->getAttributes(),
                'self'       => $this,
            ],
            $this->data(),
        );
        $data = $this->replaceInlineStyle($data);

        if ($this->shouldRender()) {
            if (!empty($this->display)) {
                return render($this->evaluate($this->display));
            }
            return view($this->getView(), $data);
        }

        return '';
    }

    public function build(): static
    {
        if (!$this->built) {
            $this->callMethods('build');
        }
        $this->callHooks('building', $this);
        $this->built = true;
        return $this;
    }

    protected function data(): array
    {
        return array_merge(
            $this->extractPublicProperties(),
            $this->getContext(),
        );
    }

    protected function replaceInlineStyle($data)
    {
        if (!empty($data['attributes']['style'])) {
            $class_random = 'cs_' . md5($data['attributes']['style']);
            admin()->styles(<<<STYLE
.$class_random {
    {$data['attributes']['style']}
}
STYLE
            );
            $data['attributes'] = ($data['attributes'])->merge(['class' => $class_random]);
            unset($data['attributes']['style']);
        }
        return $data;
    }

    public function shouldRender(): bool
    {
        if (!empty($this->shouldRenderUsing)) {
            return $this->evaluate($this->shouldRenderUsing);
        }
        return true;
    }

    protected function getView(): string
    {
        if (!empty($this->view)) {
            return evaluate($this->view, $this);
        }
        return $this->guessViewName();
    }

    protected function guessViewName(
        $prefix = 'merlion::',
        $namespace = 'Merlion\\Components\\',
        $instance = null
    ): string {
        $instance   = $instance ?: get_class($this);
        $names      = explode('\\', Str::after($instance, $namespace));
        $view_names = [];
        foreach ($names as $name) {
            $view_names [] = Str::snake($name);
        }
        $view_name = $prefix . implode('.', $view_names);

        if (view()->exists($view_name)) {
            return $view_name;
        }

        if (!empty(get_parent_class($instance))) {
            return $this->guessViewName($prefix, $namespace, get_parent_class($instance));
        }

        return '';
    }
}
