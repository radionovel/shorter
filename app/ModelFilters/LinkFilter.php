<?php
declare(strict_types=1);

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

    /**
     * @param $page
     * @return void
     */
    public function page($page)
    {
        if ($page) {
            $this->forPage($page);
        }
    }

    /**
     * @param $pageSize
     * @return void
     */
    public function size($pageSize)
    {
        if ($pageSize) {
            $this->limit($pageSize);
        }
    }

}
