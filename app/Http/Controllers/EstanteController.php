<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estante;
use App\Models\User;

class EstanteController extends Controller
{

public function update(Request $request)
{
    $user = $request->user(); // Requiere token con Sanctum

    $data = $request->validate([
        'instagram' => 'nullable|string',
        'facebook' => 'nullable|string',
        'whatsapp' => 'nullable|string',
        'logo_url' => 'nullable|url',
        'imagenes_productos_url' => 'nullable|array'
    ]);

    $estante = Estante::update(
        ['user_id' => $user->id],
        $data
    );

    return response()->json(['message' => 'Estante actualizado con éxito', 'data' => $estante]);
}

public function mostrar($id)
{
    $estante = Estante::find($id);

    if (!$estante) {
        return response()->json(['error' => 'Estante no encontrado'], 404);
    }

    return response()->json([
        'instagram' => $estante->instagram,
        'facebook' => $estante->facebook,
        'whatsapp' => $estante->whatsapp,
        'logoURL' => $estante->logo_url,
        'imagenesProductosURL' => json_decode($estante->imagenes_productos_url, true)
    ]);
}

public function listarEstantes()
{
    $estantes = Estante::with('user:id,name')->get();
    return response()->json($estantes);
}

public function asignarUsuario($id, Request $request)
{
    // Validar el user_id para asegurarse de que existe un usuario con ese ID
    $request->validate([
        'user_id' => 'required|exists:users, id',
    ]);

    // Buscar el estante por su ID
    $estante = Estante::find($id);

    // Verificar si el estante existe
    if (!$estante) {
        return response()->json(['error' => 'Estante no encontrado'], 404);
    }

    // Asignar el user_id al estante
    $estante->user_id = $request->user_id;
    
    // Guardar los cambios en el estante
    $estante->save();

    // Retornar una respuesta con el mensaje de éxito
    return response()->json(['mensaje' => 'Usuario asignado con éxito']);
}

public function misEstantes(Request $request)
{
    $user = $request->user();

    $estantes = Estante::where('user_id', $user->id)->get();

    if ($estantes->isEmpty()) {
        return response()->json([
            'asignado' => false,
            'mensaje' => 'No tienes estantes asignados.'
        ], 200);
    }

    return response()->json([
        'asignado' => true,
        'estantes' => $estantes
    ], 200);
}

public function limpiarEstante($id)
{
    $estante = Estante::find($id);
    if ($estante) {
        $estante->usuario_id = null; // Limpiar el usuario asignado
        $estante->instagram = null; // Limpiar el campo de Instagram
        $estante->facebook = null; // Limpiar el campo de Facebook
        $estante->whatsapp = null; // Limpiar el campo de WhatsApp
        $estante->logo_url = null; // Limpiar el campo del logo
        $estante->imagenes_productos_url = null; // Limpiar el campo de imágenes de productos
        $estante->save(); // Guardar los cambios en la base de datos
        return response()->json(['message' => 'Estante limpiado correctamente']);
    } 
    else 
    {
        return response()->json(['message' => 'Estante no encontrado'], 404);
    }
}
}
