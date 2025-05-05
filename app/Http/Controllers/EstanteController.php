<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estante;

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

    $estante = Estante::updateOrCreate(
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

}
