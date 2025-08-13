<?php
declare(strict_types=1);

namespace Merlion\Http\Controllers\Api;

use Merlion\Components\Renderable;

class FormSubmitController
{
    public function __invoke()
    {
        $renderable = base64_decode(request('renderable'));
        if (is_subclass_of($renderable, Renderable::class)) {
            $payload = base64_decode(request('payload') ?? []);
            /**
             * @var Renderable $renderable
             */
            $form = $renderable::make()->context(to_json($payload));
            return $form->submit();
        }
        return 'ok';
    }
}
