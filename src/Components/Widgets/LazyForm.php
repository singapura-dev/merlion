<?php
declare(strict_types=1);

namespace Merlion\Components\Widgets;

use Merlion\Components\Form\Form;

abstract class LazyForm extends Form
{
    public function buildLazyFrom()
    {
        $payload = $this->getContext() ?? [];
        $this->post("/merlion-api/form-submit?renderable=" . base64_encode(get_class($this)) . '&payload=' . base64_encode(to_string($payload)));
    }
}
