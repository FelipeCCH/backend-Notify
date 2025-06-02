<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'correo' => 'required|email',
            'contrasena' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errores' => $validator->errors()], 422);
        }

        $usuario = Usuario::where('correo', $request->correo)->first();

        if (!$usuario || !Hash::check($request->contrasena, $usuario->contrasena)) {
            return response()->json(['mensaje' => 'Credenciales inválidas'], 401);
        }

        $token = $usuario->createToken('token-auth')->plainTextToken;

        return response()->json([
            'mensaje' => 'Inicio de sesión exitoso',
            'usuario' => [
                'id_usuario' => $usuario->id_usuario,
                'nombre' => $usuario->nombre,
                'correo' => $usuario->correo
            ],
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['mensaje' => 'Sesión cerrada correctamente']);
    }

}
