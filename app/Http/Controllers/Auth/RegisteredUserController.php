<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * @param  RegisterRequest  $request
     * @return Builder|Model
     */
    public function store(RegisterRequest $request): Builder|Model
    {
        return User::query()->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'cpf' => $request->get('cpf'),
            'phone' => $request->get('phone'),
        ]);
    }
}
