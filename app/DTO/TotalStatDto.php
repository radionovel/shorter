<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class TotalStatDto extends DataTransferObject
{
    public int $total_views = 0;
    public int $unique_views = 0;
}
