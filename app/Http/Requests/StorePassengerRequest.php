<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePassengerRequest extends FormRequest
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
            'user.name' => ['required', 'string', 'max:255'],
            'user.email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'user.cpf' => ['required', 'string', 'size:11', 'unique:users,cpf'],
            'user.phone' => ['required', 'string', 'size:11'],
            
            'address.number' => ['required','numeric','min:1','max:9999999'],
            'address.complement' => ['nullable','string','max:255'],
            'address.neighborhood' => ['required','string','max:255'],
            'address.street' => ['required','string','max:255'],
            'address.zip_code' => ['required','string','size:8'],

            'passenger.name' => ['required', 'string', 'max:255'],
            'passenger.goes' => ['nullable', 'numeric'],
            'passenger.returns' => ['nullable', 'numeric'],
            'passenger.shift' => ['required','in:"M","A","N"'],
            'passenger.school_id' => ['required','exists:schools,id'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes()
    {
        return [
            'user.name' => 'Nome do responsável',
            'user.email' => 'Email do responsável',
            'user.cpf' => 'CPF do responsável',
            'user.phone' => 'Telefone do responsável',

            'address.number' => 'Número',
            'address.complement' => 'Complemento',
            'address.neighborhood' => 'Bairro',
            'address.street' => 'Rua',
            'address.zip_code' => 'CEP',

            'passenger.name' => 'Nome do passageiro',
            'passenger.goes' => 'Ida',
            'passenger.returns' => 'Volta',
            'passenger.shift' => 'Turno',
            'passenger.school_id' => 'Escola',
        ];
    }


}
