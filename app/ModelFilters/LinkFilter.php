<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class LinkFilter extends ModelFilter
{
    /**
     * @param string $title
     * @return void
     */
    public function title(string $title)
    {
        $this->where('title', '=', $title);
    }

    /**
     * @param string $tag
     * @return void
     */
    public function tag(string $tag)
    {
        $this->related('tags', 'tag', '=', $tag);
    }

}
