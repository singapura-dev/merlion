<?php
declare(strict_types=1);

namespace Merlion\Components\Layouts;

use Illuminate\Pagination\Paginator;
use Merlion\Addons\Auth\AuthBehavior;
use Merlion\Components\Concerns\Admin\HasAssets;
use Merlion\Components\Concerns\Admin\HasMenus;
use Merlion\Components\Concerns\Admin\HasRoutes;
use Merlion\Components\Concerns\Admin\HasToast;
use Merlion\Components\Concerns\HasContent;
use Merlion\Components\Renderable;

/**
 * @method $this title($title) Set page title
 * @method $this pageTitle($title)
 * @method $this pagePreTitle($title)
 * @method $this backUrl($back)
 * @method string getPagePreTitle()
 * @method string getPageTitle()
 * @method string getBackUrl()
 *
 * @mixin AuthBehavior
 */
class Admin extends Renderable
{
    use HasAssets;
    use HasContent;
    use HasMenus;
    use HasRoutes;
    use HasToast;

    public static string $adminView = 'merlion::layouts.admin';
    public static string $blankView = 'merlion::layouts.admin_blank';

    public mixed $title = null;
    public mixed $pageTitle = null;
    public mixed $pagePreTitle = null;
    public mixed $backUrl = null;

    protected bool $booted = false;

    public static function serving($callback): void
    {
        static::addStaticHook('serving', $callback);
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

    public function getView(): string
    {
        return $this->view ?? static::$adminView;
    }

    public function hasPageHeader(): bool
    {
        return !empty($this->backUrl) || !empty($this->pageTitle) || !empty($this->pagePreTitle) || !empty($this->getContent('header'));
    }
}
