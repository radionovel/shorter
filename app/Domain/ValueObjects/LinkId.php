<?php

namespace App\Domain\ValueObjects;

class LinkId
{

    public function __construct(private int $linkId)
    {
    }

    /**
     * @return int
     */
    public function getLinkId(): int
    {
        return $this->linkId;
    }

}
