<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'number' => ['required', 'numeric', 'min:1', 'max:9999999'],
            'complement' => ['sometimes', 'string', 'max:255'],
            'neighborhood' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'zip_code' => ['required', 'string', 'size:8'],
            'external_city_id' => ['required', 'numeric'],
        ];
    }
}
