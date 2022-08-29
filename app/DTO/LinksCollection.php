<?php
declare(strict_types=1);

namespace App\DTO;

use ArrayAccess;
use Illuminate\Support\Collection;

/**
 * @implements ArrayAccess<int, LinkDto>
 */
class LinksCollection extends Collection
{
}
