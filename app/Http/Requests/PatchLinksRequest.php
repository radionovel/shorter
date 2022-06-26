<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatchLinksRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'long_url' => 'url',
            'title' => 'string',
            'tags' => 'array',
            'tags.*' => 'string',
        ];
    }
}
