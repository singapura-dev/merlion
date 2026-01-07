<?php

declare(strict_types=1);

namespace Merlion\Components\Concerns\Admin;

/**
 * @method array getCss()
 * @method array getJs()
 * @method array getStyle()
 * @method array getScript()
 */
trait HasAssets
{
    public array $css = [];

    public array $js = [];

    public array $style = [];
    public array $script = [];
    public array $vite = [];

    public function css($css):  static
    {
        $css = is_array($css) ? $css : func_get_args();
        array_push($this->css, ...$css);
        return $this;
    }

    public function js($js): static
    {
        $js = is_array($js) ? $js : func_get_args();
        array_push($this->js, ...$js);
        return $this;
    }

    public function styles($style): static
    {
        $style = is_array($style) ? $style : func_get_args();
        array_push($this->style, ...$style);
        return $this;
    }

    public function scripts($script): static
    {
        $script = is_array($script) ? $script : func_get_args();
        array_push($this->script, ...$script);
        return $this;
    }

    public function vite($value)
    {
        $this->vite = $value;
        return $this;
    }
}
