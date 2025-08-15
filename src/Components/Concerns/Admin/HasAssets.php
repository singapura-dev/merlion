<?php

declare(strict_types=1);

namespace Merlion\Components\Concerns\Admin;

/**
 * @method array getCss()
 * @method array getJs()
 * @method array getStyle()
 * @method array getScript()
 * @method $this cspNonce($cspNonce)
 * @method string getCspNonce()
 * @method $this brandLogo($logo)
 * @method $this brandName($name)
 * @method string getBrandLogo()
 * @method string getBrandName()
 */
trait HasAssets
{

    public string $cspNonce = '';
    public string $brandLogo = '';
    public string $brandName = '';

    public array $css = [
//        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap',
//        '/vendor/merlion/vendors/apexcharts/apexcharts.css',
//        '/vendor/merlion/vendors/keenicons/styles.bundle.css',
//        '/vendor/merlion/css/styles.css',
        'https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler.min.css',
        'https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler-themes.min.css',
        'https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler-flags.min.css',
        'https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.min.css',
        'https://cdn.jsdelivr.net/npm/@tabler/icons-webfont/dist/tabler-icons.min.css',
        'https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css',
        '/vendor/merlion/css/merlion.css',
    ];
    public array $js = [
//        '/vendor/merlion/js/core.bundle.js',
//        '/vendor/merlion/vendors/ktui/ktui.min.js',
//        '/vendor/merlion/vendors/apexcharts/apexcharts.min.js',
//        '/vendor/merlion/js/widgets/general.js',
        'https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/js/tabler.min.js',
        'https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js',
        'https://cdn.jsdelivr.net/npm/toastify-js',
        'https://cdn.jsdelivr.net/npm/hugerte@1/hugerte.min.js',
        '/vendor/merlion/js/merlion.js',
    ];

    public array $style = [];
    public array $script = [];

    public function css($css): void
    {
        $css = is_array($css) ? $css : func_get_args();
        array_push($this->css, ...$css);
    }

    public function js($js): void
    {
        $js = is_array($js) ? $js : func_get_args();
        array_push($this->js, ...$js);
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

    public function view($path): string
    {
        $full_path = 'merlion::inc.' . $this->id . '.' . $path;
        if (view()->exists($full_path)) {
            return $full_path;
        }
        return 'merlion::inc.admin.' . $path;
    }
}
