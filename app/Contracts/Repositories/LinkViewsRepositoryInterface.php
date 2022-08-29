<?php

namespace App\Contracts\Repositories;

use App\DTO\CreateLinkViewDto;
use App\DTO\LinkViewDto;
use App\DTO\TotalStatDto;
use App\Exceptions\LinkNotFound;

interface LinkViewsRepositoryInterface
{
    public function storeView(CreateLinkViewDto $link): LinkViewDto;

    public function totalStats(array $filter): TotalStatDto;

    /**
     * @param int $linkId
     * @param int $page
     * @return array
     *
     * @throws LinkNotFound
     */
    public function linkStats(int $linkId, int $page): array;
}
