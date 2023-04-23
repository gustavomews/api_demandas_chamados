<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function login(Request $request) {
        $credentials = $request->all(['email', 'password']);

        // autenticacao (email e senha)
        $token = auth('api')->attempt($credentials);

        // usuário autenticado - Retorna o JWT
        if($token) {
            return response()->json(['token' => $token]);
        } else { // inválido
            return response()->json(['erro' => 'Usuário ou senha inválido!'], 403);

            // 401 - Unauthorized = Não autorizado
            // 403 - Forbidden = Proibido / Login inválido
        }
    }

    public function logout() {
        auth('api')->logout();
        return response()->json(['msg' => 'Logout realizado com sucesso!']);
    }

    public function refresh() {
        $token = auth('api')->refresh(); // client encaminhe um jwt válido
        return response()->json(['token' => $token]);
    }

    public function me() {
        return response()->json(auth()->user());
    }
}
