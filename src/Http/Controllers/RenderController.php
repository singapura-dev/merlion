<?php
declare(strict_types=1);

namespace Merlion\Http\Controllers;

use Merlion\Components\Renderable;

class RenderController
{
    public function __invoke($data)
    {
        $params = from_url_data($data);

        $renderable = $params['renderable'] ?? null;
        if (empty($renderable)) {
            abort(404);
        }
        if (is_subclass_of($renderable, Renderable::class)) {
            /** @var Renderable $instance */
            $instance = $renderable::make();
            $payload  = to_json($params['payload'] ?? []);
            $instance->context($payload);
            return $instance->render();
        }
        return request()->all();
    }
}
