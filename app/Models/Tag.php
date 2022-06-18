<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $link_id
 * @property string $tag
 *
 * @method static static create(array $attributes);
 */
class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag',
    ];

}
