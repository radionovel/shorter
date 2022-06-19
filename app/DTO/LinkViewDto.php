<?php

namespace App\DTO;

use DateTimeInterface;
use Spatie\DataTransferObject\DataTransferObject;

class LinkViewDto extends DataTransferObject
{
    public int $id;
    public string $user_id;
    public string $link_id;
    public DateTimeInterface $view_date;
    public string $user_ip;
    public string $user_agent;
}
