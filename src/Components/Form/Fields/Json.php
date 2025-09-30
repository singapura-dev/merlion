<?php
declare(strict_types=1);

namespace Merlion\Components\Form\Fields;

class Json extends Field
{
    public function getDataFromRequest($request = null)
    {
        $result = parent::getDataFromRequest($request);
        return to_json($result);
    }
}
