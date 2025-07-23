<?php

declare(strict_types=1);

namespace Merlion\Components\Layouts;

use Closure;
use Merlion\Components\Concerns\AsContainer;
use Merlion\Components\Concerns\HasBrand;
use Merlion\Components\Renderable;

/**
 * @method $this title(string|Closure $title) Set html head title
 * @method $this cspNonce(string|Closure $cspNonce) Set csp nonce
 * @method string|null getCspNonce() Get csp nonce
 */
abstract class Html extends Renderable
{
    use AsContainer;
    use HasBrand;

    public string|Closure|null $title = null;
    public string|Closure|null $cspNonce = null;

    public function setupTheme(): static
    {
        return $this->defaultAttributes([
            'data-layout'        => 'vertical',
            'data-topbar'        => 'light',
            'data-sidebar'       => 'dark',
            'data-sidebar-size'  => 'lg',
            'data-sidebar-image' => 'none',
            'data-preloader'     => 'disable',
            'data-theme'         => 'default',
            'data-theme-colors'  => 'default',
        ]);
    }

    public array $css = [
        '/vendor/merlion/css/bootstrap.min.css',
        '/vendor/merlion/css/app.min.css',
        '/vendor/merlion/css/icons.min.css',
        '/vendor/merlion/css/custom.min.css',
        'https://cdn.jsdelivr.net/npm/@tabler/icons-webfont/dist/tabler-icons.min.css',
        'https://cdn.jsdelivr.net/npm/@tabler/core/dist/css/tabler-flags.min.css',
    ];
    public array $js = [
        '/vendor/merlion/libs/jquery/jquery.min.js',
        '/vendor/merlion/libs/bootstrap/js/bootstrap.bundle.min.js',
        '/vendor/merlion/libs/simplebar/simplebar.min.js',
        '/vendor/merlion/libs/node-waves/waves.min.js',
        '/vendor/merlion/libs/feather-icons/feather.min.js',
        '/vendor/merlion/libs/toastify-js/src/toastify.js',
        '/vendor/merlion/js/theme.js',
        '/vendor/merlion/js/merlion.js',
    ];
    public array $style = [];
    public array $script = [];

    public function css($css): static
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

    public function style($style): static
    {
        $style = is_array($style) ? $style : func_get_args();
        array_push($this->style, ...$style);
        return $this;
    }

    public function script($script): static
    {
        $script = is_array($script) ? $script : func_get_args();
        array_push($this->script, ...$script);
        return $this;
    }

    public function getCurrentLanguage(): string
    {
        return session('locale', app()->getLocale());
    }

    public function setCurrentLanguage($lang): static
    {
        session()->put('locale', $lang);
        return $this;
    }

    public function updateLanguage()
    {
        app()->setLocale($this->getCurrentLanguage());
        return $this;
    }
}
