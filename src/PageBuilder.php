<?php

namespace Merlion;

use Exception;
use Merlion\Components\Renderable;

class PageBuilder
{
    public static array $renderableMap = [
        'admin'  => Components\Layouts\Admin::class,
        'flex'   => Components\Flex::class,
        'button' => Components\Button::class,
        'table'  => Components\Table\Table::class,
    ];

    /**
     * @throws Exception
     */
    public static function build($type = 'admin', array $data = []): Renderable
    {
        if (empty(static::$renderableMap[$type])) {
            throw new Exception("Renderable type {$type} not found");
        }
        if (!empty($data['content'])) {
            $content = $data['content'];
            unset($data['content']);
        }
        $container = static::$renderableMap[$type]::make($data);
        if (!empty($content)) {
            foreach ($content as $value) {
                if (is_array($value)) {
                    $sub_content = static::build($value['type'], $value);
                    $container->content($sub_content, $value['position'] ?? null);
                }
            }
        }
        return $container;
    }
}
