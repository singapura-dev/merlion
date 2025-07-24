<?php
declare(strict_types=1);

namespace Merlion\Components\Concerns;

use Closure;

/**
 * @method $this brandName(string|Closure $name) Set brand name
 * @method $this brandShortName(string|Closure $name) Set brand name
 * @method string getBrandName() Get brand name
 * @method string getBrandShortName() Get brand short name
 * @method $this brandLogo(string|Closure $logoUrl) Set brand logo
 * @method $this brandLogoSmall(string|Closure $logoUrl) Set brand small logo
 * @method $this brandLogoDark(string|Closure $logoUrl) Set brand dark logo
 * @method $this brandLogoSmallDark(string|Closure $logoUrl) Set brand small dark logo
 * @method string getBrandLogo() Get brand logo
 * @method string getBrandLogoSmall() Get brand small logo
 * @method string getBrandLogoDark() Get brand dark logo
 * @method string getBrandLogoSmallDark() Get brand small dark logo
 * @method $this favicon(string|Closure $faviconUrl) Set favicon
 * @method string getFavicon() Get favicon
 */
trait HasBrand
{
    public string|Closure|null $brandName = '';
    public string|Closure|null $brandShortName = '';
    public string|Closure|null $brandLogo = '/vendor/merlion/images/logo-light.png';
    public string|Closure|null $brandLogoSmall = '/vendor/merlion/images/logo-sm.png';
    public string|Closure|null $brandLogoDark = '/vendor/merlion/images/logo-dark.png';
    public string|Closure|null $brandLogoSmallDark = '';
    public string|Closure|null $favicon = '/favicon.ico';
}
