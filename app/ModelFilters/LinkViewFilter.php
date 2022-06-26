<?php
declare(strict_types=1);

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class LinkViewFilter extends ModelFilter
{
    public function fromDate($from)
    {
        $this->where('view_date', '>=', $from);
    }

    public function toDate($to)
    {
        $this->where('view_date', '<=', $to);
    }
}
