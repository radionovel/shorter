<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class LinkDto extends DataTransferObject
{
    public int $id;
    public string $code;
    public string $short_url;
    public string $long_url;
    public string $title = '';
    public array $tags = [];
}
