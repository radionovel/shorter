<?php

namespace App\DTO;

use DateTimeInterface;
use Spatie\DataTransferObject\DataTransferObject;

class CreateLinkViewDto extends DataTransferObject
{
    public int $link_id;
    public string $user_id;
    public DateTimeInterface $view_date;
    public string $user_ip;
    public string $user_agent;
}
