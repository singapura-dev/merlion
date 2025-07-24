<?php
declare(strict_types=1);

namespace Merlion\Components\Grid;

use Merlion\Components\Concerns\HasModel;
use Merlion\Components\Container;
use Merlion\Components\Grid\Displayers\Displayer;
use Merlion\Components\Renderable;

class Grid extends Container
{
    use HasModel;

    public function getDisplayers($parent = null): array
    {
        $displayers = [];
        if ($parent === null) {
            $parent = $this;
        }

        if ($parent instanceof Displayer) {
            $parent->grid = $this;
            $displayers[] = $parent;
        } elseif ($parent instanceof Renderable) {
            if (method_exists($parent, 'content')) {
                $children = $parent->getContent();
                if (!empty($children)) {
                    $sub_displayers = $this->getDisplayers($children);
                    array_push($displayers, ...$sub_displayers);
                }
            }
        } elseif (is_array($parent)) {
            foreach ($parent as $item) {
                if (!empty($item)) {
                    $sub_displayers = $this->getDisplayers($item);
                    array_push($displayers, ...$sub_displayers);
                }
            }
        } else {
            dd($parent);
        }

        return $displayers;
    }

    public function renderGrid(): void
    {
        $this->getDisplayers();
    }
}
