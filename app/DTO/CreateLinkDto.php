<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class CreateLinkDto extends DataTransferObject
{
    public string $long_url;
    public string $title = '';
    public array $tags = [];
}
