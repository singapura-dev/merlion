<?php

namespace Merlion;

use Exception;
use Merlion\Components\Renderable;

class PageBuilder
{
    public static array $renderableMap = [
        'admin'       => Components\Layouts\Admin::class,
        'flex'        => Components\Container\Flex::class,
        'button'      => Components\Button::class,
        'table'       => Components\Table\Table::class,
        'form'        => Components\Form\Form::class,
        'fields.text' => Components\Form\Fields\Text::class,
    ];

    /**
     * @throws Exception
     */
    public static function build(array $data = []): Renderable
    {
        $type = $data['type'];

        if (!empty($data['content'])) {
            $content = $data['content'];
            unset($data['content']);
        }

        $container = static::$renderableMap[$type]::make($data);

        if (!empty($content)) {
            foreach ($content as $value) {
                if (is_array($value)) {
                    $sub_content = static::build($value);
                    $container->content($sub_content, $value['position'] ?? null);
                }
            }
        }
        return $container;
    }
}
