<?php

namespace Merlion\Components\Concerns\Admin;

/**
 * @method static brandLogo($logo)
 * @method static brandName($name)
 * @method string getBrandLogo()
 * @method string getBrandName()
 */
trait HasBrand
{
    public mixed $brandLogo = '';
    public mixed $brandName = '';
}
