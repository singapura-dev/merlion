<?php

declare(strict_types=1);

namespace Merlion\Components\Layouts;

use Closure;
use Merlion\Components\Concerns\AsContainer;
use Merlion\Components\Concerns\HasBrand;
use Merlion\Components\Renderable;

/**
 * @method $this title(string|Closure $title) Set html head title
 * @method string|null getTitle() Get html head title
 * @method $this cspNonce(string|Closure $cspNonce) Set csp nonce
 * @method string|null getCspNonce() Get csp nonce
 */
abstract class Html extends Renderable
{
    use AsContainer;
    use HasBrand;

    public string|Closure|null $title = null;
    public string|Closure|null $layout = 'condensed';
    public string|Closure|null $cspNonce = null;

    protected function getDefaultAttributes(): array
    {
        return [
        ];
    }

    public array $css = [
        '/vendor/merlion/css/tabler.min.css',
        '/vendor/merlion/css/merlion.css',
        'https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.min.css',
        'https://cdn.jsdelivr.net/npm/@tabler/icons-webfont/dist/tabler-icons.min.css',
        'https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler-flags.min.css',
    ];

    public array $js = [
        'https://code.jquery.com/jquery-3.7.1.min.js',
        '/vendor/merlion/js/tabler.min.js',
        '/vendor/merlion/js/merlion.js',
        '/vendor/merlion/js/theme.js',
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

    public function getLanguage(): string
    {
        if (!empty(request('lang'))) {
            return request('lang');
        }
        $lang = session('locale');
        if (empty($lang) && auth()->user()) {
            $lang = auth()->user()->language;
        }
        return $lang ?? app()->getLocale();
    }

    public function setLanguage($lang): static
    {
        session()->put('locale', $lang);
        return $this;
    }

    public function updateLanguage(): static
    {
        app()->setLocale($this->getLanguage());
        return $this;
    }
}
