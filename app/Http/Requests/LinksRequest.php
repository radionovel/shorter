<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinksRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'string',
            'tag' => 'string',
            'page' => 'integer',
        ];
    }

}
