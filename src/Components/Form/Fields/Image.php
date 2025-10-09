<?php
declare(strict_types=1);

namespace Merlion\Components\Form\Fields;

use Closure;

/**
 * @method $this accept(string|Closure $accept) Set accept
 * @method $this multiple(bool|Closure $multiple) Set multiple
 * @method string getAccept()
 * @method boolean getMultiple()
 */
class Image extends File
{
    public mixed $accept = 'image/*';
}
