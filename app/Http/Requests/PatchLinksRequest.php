<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatchLinksRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
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
