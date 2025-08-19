<?php
declare(strict_types=1);

namespace Merlion\Components\Table\Columns;

use Merlion\Components\Concerns\AsLink;
use Merlion\Components\Concerns\Copyable;
use Merlion\Components\Concerns\HasIcon;
use Merlion\Components\Concerns\HasModal;

/**
 * @method $this labels(array|\Closure $labels)
 * @method array getLabels()
 */
class Text extends Column
{
    use Copyable;
    use AsLink;
    use HasIcon;
    use HasModal;

    public mixed $labels = [];

    public function renderText()
    {
        if (!empty($labels = $this->getLabels())) {
            $value = $this->getValue();
            $color = 'primary';
            foreach ($labels as $_value => $_color) {
                if ($value == $_value) {
                    $color = $_color;
                }
            }
            $this->class('badge bg-' . $color . ' text-' . $color . '-fg');
        }
    }

    public function diaplayValue()
    {
        return $this->getValue();
    }
}
