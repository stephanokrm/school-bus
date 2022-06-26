<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRouteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            '*.order' => ['required', 'numeric', 'min:1'],
            '*.passenger_id' => ['required', 'numeric', 'exists:passengers'],
            '*.school_id' => ['required', 'numeric', 'exists:schools']
        ];
    }
}
