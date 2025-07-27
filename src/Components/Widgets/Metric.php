<?php

namespace Merlion\Components\Widgets;

use Merlion\Components\Concerns\HasLink;
use Merlion\Components\Renderable;

class Metric extends Renderable
{
    use HasLink;

    public $view = 'merlion::widgets.metric';

    public mixed $icon = null;
    public mixed $title = null;
    public mixed $sub_title = null;
    public mixed $color = 'primary';

}
