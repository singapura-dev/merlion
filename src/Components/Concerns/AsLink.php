<?php
declare(strict_types=1);

namespace Merlion\Components\Concerns;

/**
 * @method string getLink()
 * @method string getTarget()
 */
trait AsLink
{
    public mixed $link = null;
    public mixed $target = null;

    public function link(mixed $link, $target = null): static
    {
        $this->link = $link;
        if (!is_null($target)) {
            $this->target = $target;
        }
        return $this;
    }

    public function hasLink(): bool
    {
        return !empty($this->link);
    }

    public function renderAsLink(): void
    {
        if (!empty($this->link)) {
            $this->withAttributes([
                'href' => $this->getLink()
            ]);
            if (!empty($this->target)) {
                $this->withAttributes([
                    'target' => $this->getTarget(),
                ]);
            }
        }
    }
}
