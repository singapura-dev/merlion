<?php
declare(strict_types=1);

namespace Merlion\Components;

use Merlion\Components\Concerns\HasContent;
use Merlion\Components\Concerns\HasIcon;

/**
 * @method $this closable(bool $closable)
 * @method $this type(string $type)
 */
class Alert extends Renderable
{
    use HasIcon;
    use HasContent;

    public mixed $type = 'danger';
    public bool $closable = true;

    public function success()
    {
        return $this->type('success');
    }
}
