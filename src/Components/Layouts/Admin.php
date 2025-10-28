<?php
declare(strict_types=1);

namespace Merlion\Components\Layouts;

use Illuminate\Pagination\Paginator;
use Merlion\Addons\Auth\AuthBehavior;
use Merlion\Components\Concerns\Admin\Defaultable;
use Merlion\Components\Concerns\Admin\HasAuth;
use Merlion\Components\Concerns\Admin\HasMenus;
use Merlion\Components\Concerns\Admin\HasRoutes;
use Merlion\Components\Concerns\Admin\HasToast;
use Merlion\Components\Concerns\HasContent;
use Merlion\Components\Renderable;

/**
 * @method static title($title) Set page title
 * @method static pageTitle($title)
 * @method static pagePreTitle($title)
 * @method static backUrl($back)
 * @method string getPagePreTitle()
 * @method string getPageTitle()
 * @method string getBackUrl()
 * @method static cspNonce($cspNonce)
 * @method string getCspNonce()
 * @method static brandLogo($logo)
 * @method static brandName($name)
 * @method string getBrandLogo()
 * @method string getBrandName()
 */
class Admin extends Renderable
{
    use Defaultable;
    use HasAuth;
    use HasContent;
    use HasMenus;
    use HasRoutes;
    use HasToast;

    public static string $adminView = 'merlion::layouts.admin';
    public static string $blankView = 'merlion::layouts.admin_blank';

    public string $cspNonce = '';
    public string $brandLogo = '';
    public string $brandName = '';

    public array $css = [
        'https://cdn.jsdelivr.net/npm/@tabler/core/dist/css/tabler.min.css',
        'https://cdn.jsdelivr.net/npm/@tabler/core/dist/css/tabler-themes.min.css',
        'https://cdn.jsdelivr.net/npm/@tabler/core/dist/css/tabler-flags.min.css',
        'https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.min.css',
        'https://cdn.jsdelivr.net/npm/@tabler/icons-webfont/dist/tabler-icons.min.css',
        'https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css',
        'https://cdn.jsdelivr.net/npm/sweetalert2@11.22.4/dist/sweetalert2.min.css',
        '/vendor/merlion/css/merlion.css',
    ];

    public array $js = [
        'https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js',
        'https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js',
        'https://cdn.jsdelivr.net/npm/toastify-js',
        'https://cdn.jsdelivr.net/npm/hugerte/hugerte.min.js',
        'https://cdn.jsdelivr.net/npm/sweetalert2@11.22.4/dist/sweetalert2.min.js',
        '/vendor/merlion/js/merlion.js',
    ];

    public mixed $title = null;
    public mixed $pageTitle = null;
    public mixed $pagePreTitle = null;
    public mixed $backUrl = null;

    protected bool $booted = false;

    public function serving($callback): static
    {
        $this->addHook('serving', $callback);
        return $this;
    }

    public function boot(): void
    {
        if ($this->booted) {
            return;
        }
        Paginator::useBootstrapFive();

        static::callStaticHooks('booting', $this);
        $this->callHooks('booting', $this);
        $this->callMethods('boot', $this);

        $this->booted = true;
    }

    public function blank(): static
    {
        $this->view = static::$blankView;
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

    public function getView(): string
    {
        return $this->view ?? static::$adminView;
    }

    public function hasPageHeader(): bool
    {
        return !empty($this->backUrl) || !empty($this->pageTitle) || !empty($this->pagePreTitle) || !empty($this->getContent('header'));
    }
}
