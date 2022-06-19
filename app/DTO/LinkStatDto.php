<?php

namespace App\DTO;

use DateTimeInterface;
use Spatie\DataTransferObject\DataTransferObject;

class LinkStatDto extends DataTransferObject
{
    public int $total_views;
    public int $unique_views;
    public DateTimeInterface $date;
}
