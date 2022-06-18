<?php

namespace App\Contracts\Services;

use App\DTO\CreateLinksCollection;

interface LinksServiceInterface
{
    public function storeCollection(CreateLinksCollection $createLinksCollection);
}
