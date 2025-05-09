<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

public function checkUsername(Request $request)
{
    $request->validate([
        'username' => 'required|string|min:3|max:20'
    ]);

    $exists = User::where('name', $request->username)->exists();

    if ($exists) {
        return response()->json(['error' => 'Nombre de usuario no disponible'], 409);
    }

    return response()->json(['message' => 'Nombre disponible'], 200);
}

public function updateProfile(Request $request)
{
    $request->validate([
        'username' => 'required|string|min:8|max:10'
    ]);

    $user = $request->user(); // ← Esto usa el token de autenticación enviado desde Unity

    $user->name = $request->username;
    $user->save();

    return response()->json(['message' => 'Perfil actualizado exitosamente'], 200);
}

public function listarUsuarios()
{
        return response()->json(
            User::select('id', 'name', 'email')->get()
        );
}

}
