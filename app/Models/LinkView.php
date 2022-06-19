<?php

namespace App\Models;

use App\DTO\LinkViewDto;
use App\ModelFilters\LinkViewFilter;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

/**
 * @method static static create(array $attributes = [])
 */
class LinkView extends Model
{
    use HasFactory;
    use Filterable;


    protected $fillable = [
        'link_id', 'user_id', 'view_date', 'user_ip', 'user_agent',
    ];

    /**
     * @return string|null
     */
    public function modelFilter(): ?string
    {
        return $this->provideFilter(LinkViewFilter::class);
    }

    /**
     * @return LinkViewDto
     * @throws UnknownProperties
     */
    public function dto(): LinkViewDto
    {
        return new LinkViewDto($this->toArray());
    }

}
