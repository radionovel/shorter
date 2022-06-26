<?php
declare(strict_types=1);

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class LinkViewDto extends DataTransferObject
{
    public int $id;
    public string $user_id;
    public string $link_id;
    public \DateTimeImmutable $view_date;
    public string $user_ip;
    public string $user_agent;
}
