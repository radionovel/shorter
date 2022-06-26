<?php

namespace App\Factories;

use App\DTO\CreateLinkViewDto;
use Carbon\CarbonImmutable;

class LinkViewFactory implements LinkViewFactoryInterface
{
    public function create(int $linkId, \DateTimeImmutable $viewDate, string $userIp, string $userAgent): CreateLinkViewDto
    {
        return new CreateLinkViewDto($linkId,
            hash('sha3-256', $userIp . $userAgent),
            CarbonImmutable::now()->toDateTimeImmutable(),
            $userIp,
            $userAgent
        );
    }

}
