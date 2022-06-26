<?php

namespace App\Contracts\Services;

use App\DTO\CreateLinkDto;

interface LinksServiceInterface
{
    /**
     * @param array<CreateLinkDto> $createLinksCollection
     * @return mixed
     */
    public function storeCollection(array $createLinksCollection): mixed;
}
