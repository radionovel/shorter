<?php

namespace App\Factories;

use App\DTO\CreateLinkViewDto;

interface LinkViewFactoryInterface
{
    public function create(int $linkId,
                           \DateTimeImmutable $viewDate,
                           string $userIp,
                           string $userAgent): CreateLinkViewDto;
}
