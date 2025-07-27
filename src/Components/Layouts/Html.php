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

    public static array $css = [
        '/vendor/merlion/css/tabler.min.css',
        '/vendor/merlion/css/merlion.css',
        'https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.min.css',
        'https://cdn.jsdelivr.net/npm/@tabler/icons-webfont/dist/tabler-icons.min.css',
        'https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler-flags.min.css',
        'https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css',
    ];

    public static array $js = [
        'https://code.jquery.com/jquery-3.7.1.min.js',
        '/vendor/merlion/js/tabler.min.js',
        '/vendor/merlion/js/merlion.js',
        '/vendor/merlion/js/theme.js',
        'https://cdn.jsdelivr.net/npm/toastify-js',
    ];

    public array $style = [];
    public array $script = [];

    public static function css($css): void
    {
        $css = is_array($css) ? $css : func_get_args();
        array_push(static::$css, ...$css);
    }

    public static function js($js): void
    {
        $js = is_array($js) ? $js : func_get_args();
        array_push(static::$js, ...$js);
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

    public function getLanguage(): string
    {
        if (!empty(request('lang'))) {
            return request('lang');
        }
        $lang = session('locale');
        if (auth()->user() && !empty(auth()->user()->language)) {
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
