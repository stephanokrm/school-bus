<?php

namespace App\Http\Requests;

class StoreSchoolRequest extends StoreAddressRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return parent::authorize();
    }

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            ...parent::rules(),
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
