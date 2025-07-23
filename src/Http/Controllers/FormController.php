<?php
declare(strict_types=1);

namespace Merlion\Http\Controllers;

use Exception;
use Merlion\Components\Form\Form;
use Merlion\Components\Renderable;

class FormController
{
    public function __invoke($data)
    {
        $params = from_url_data($data);

        $renderable = $params['renderable'] ?? null;
        if (empty($renderable)) {
            abort(404);
        }
        if (is_subclass_of($renderable, Form::class)) {
            /** @var Renderable $instance */
            $instance = $renderable::make();
            $payload  = to_json($params['payload'] ?? []);
            $instance->context($payload);
            if (method_exists($instance, 'submit')) {
                return $instance->submit();
            }
            throw new Exception('Form must have submit method');
        }
        abort(404);
    }
}
