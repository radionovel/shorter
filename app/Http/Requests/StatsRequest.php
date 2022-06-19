<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatsRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'fromDate' => 'date_format:Y-m-d',
            'toDate' => 'date_format:Y-m-d'
        ];
    }

    /**
     * @return void
     */
    public function prepareForValidation()
    {
        $request = [];
        if ($this->has('from')) {
            $request['fromDate'] = $this->get('from');
        }

        if ($this->has('to')) {
            $request['toDate'] = $this->get('to');
        }

        $this->replace($request);
    }
}
