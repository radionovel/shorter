<?php
declare(strict_types=1);

namespace App\Models;

use App\DTO\LinkDto;
use App\ModelFilters\LinkFilter;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

/**
 * @property int $id
 * @property string $code
 * @property string $link
 * @property string $title
 * @property Collection<Tag> $tags
 * @property string $status
 *
 * @method static static create(array $attributes);
 * @method static static find(int $id);
 * @method static static findOrFail(int $id);
 * @method static static Builder filter(array $attributes);
 */
class Link extends Model
{
    use HasFactory;
    use Filterable;


    protected $fillable = [
        'code', 'link', 'title',
    ];

    /**
     * @return string|null
     */
    public function modelFilter(): ?string
    {
        return $this->provideFilter(LinkFilter::class);
    }

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * @param array $tags
     * @return LinkDto
     * @throws UnknownProperties
     */
    public function dto(array $tags = []): LinkDto
    {
        return new LinkDto([
            'id' => $this->id,
            'code' => $this->code,
            'short_url' => 'https://shorter.local/go/' . $this->code,
            'long_url' => $this->link,
            'title' => $this->title,
            'tags' => $tags
        ]);
    }
}
