<?php
declare(strict_types=1);

namespace Merlion\Components\Infolist;

use Merlion\Components\Concerns\HasModel;
use Merlion\Components\Container;
use Merlion\Components\Infolist\Entry\Entry;
use Merlion\Components\Renderable;

class Infolist extends Container
{
    use HasModel;

    public function getSchemas($parent = null): array
    {
        $schemas = [];
        if ($parent === null) {
            $parent = $this;
        }

        if ($parent instanceof Entry) {
            $parent->infolist = $this;
            $schemas[]        = $parent;
        } elseif ($parent instanceof Renderable) {
            if (method_exists($parent, 'content')) {
                $children = $parent->getContent();
                if (!empty($children)) {
                    $sub_schemas = $this->getSchemas($children);
                    array_push($schemas, ...$sub_schemas);
                }
            }
        } elseif (is_array($parent)) {
            foreach ($parent as $item) {
                if (!empty($item)) {
                    $sub_schemas = $this->getSchemas($item);
                    array_push($schemas, ...$sub_schemas);
                }
            }
        } else {
            dd($parent);
        }

        return $schemas;
    }

    public function renderInfolist(): void
    {
        $this->class('datagrid');
        $this->getSchemas();
    }
}
