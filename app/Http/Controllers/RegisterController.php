<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function __construct(User $user) {
        $this->user = $user;
    }
    //
    public function register(Request $request) {
        // ---------------------------------------------------------------------- Validate
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
        $feedback = [
            'required' => 'O campo é obrigatório',
            'string' => 'Conteúdo inválido',
            'max' => 'O número de caracteres máximos é 255',
            'email.email' => 'E-mail inválido',
            'email.unique' => 'O e-mail informado já está em uso',
            'password.min' => 'O número mínimo de caracteres é 6',
            'password.confirmed' => 'Confirme a senha informada'
        ];

        $request->validate($rules, $feedback);

        // ---------------------------------------------------------------------- Create User
        $user = $request->all();
        $user['password'] = bcrypt($user['password']);
        $user = $this->user->create($user);

        // ---------------------------------------------------------------------- Return response
        return response()->json($user, 201);
    }
}
