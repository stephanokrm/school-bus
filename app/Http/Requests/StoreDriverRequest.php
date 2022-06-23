<?php

namespace App\Http\Requests;

class StoreDriverRequest extends StoreUserRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return parent::authorize();
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            ...parent::rules(),
            'cnh' => ['required', 'string', 'size:11', 'unique:drivers'],
        ];
    }
}
