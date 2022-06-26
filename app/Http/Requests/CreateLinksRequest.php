<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\DTO\CreateLinkDto;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property array $links
 */
class CreateLinksRequest extends FormRequest
{
    /**
     * @return array<CreateLinkDto>
     */
    public function links(): array
    {
        return array_map(function (array $link) {
            return new CreateLinkDto($link['long_url'], $link['title'], $link['tags']);
        }, $this->links);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'links' => 'required|array',
            'links.*.long_url' => 'required|url',
            'links.*.title' => 'string',
            'links.*.tags' => 'array',
            'links.*.tags.*' => 'string',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'links.*.long_url.required' => 'URL обязательный параметр',
            'links.*.long_url.url' => 'Некорректный URL',
            'links.*.title.string' => 'Название URL должно быть строкой',
            'links.*.tags.array' => 'Параметр tags должен содержать массив',
            'links.*.tags.*.string' => 'Теги должны быть в виде строки',
        ];
    }

    /**
     * @return void
     */
    public function prepareForValidation()
    {
        $request = $this->request->all();
        if (isset($request['long_url'])) {
            $request = [$request];
        }

        if (!empty($request)) {
            $this->replace([
                'links' => $request
            ]);
        }
    }
}
