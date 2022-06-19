<?php

namespace App\Contracts\Repositories;

use App\DTO\CreateLinkViewDto;
use App\DTO\LinkViewDto;
use App\DTO\TotalStatDto;
use Illuminate\Support\Collection;

interface LinkViewsRepositoryInterface
{
    public function storeView(CreateLinkViewDto $link): LinkViewDto;

    public function totalStats(array $filter): TotalStatDto;

    public function linkStats(int $linkId): Collection;
}
