<?php

namespace Merlion\Support;

abstract class Behavior
{
    protected mixed $host = null;

    protected function getHost(): mixed
    {
        return $this->host;
    }

    public function setHost($host): void
    {
        $this->host = $host;
    }
}
