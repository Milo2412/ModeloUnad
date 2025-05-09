<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicidad;

class PublicidadController extends Controller
{
    
public function obtenerPublicidad()
{
    $publicidad = Publicidad::first(); // o where('id', 1)->first() si usas una única fila
    return response()->json($publicidad);
}

public function actualizarPublicidad(Request $request)
{
    $publicidad = Publicidad::first(); // Si solo hay una fila
    if (!$publicidad) {
        $publicidad = new Publicidad();
    }

    $campos = [
        'lobby_principal', 'lobby1', 'lobby2', 'lobby3', 'lobby4',
        'afichepublicidad1','afichepublicidad2','afichepublicidad3','afichepublicidad4',
        'afichepublicidad5','afichepublicidad6','afichepublicidad7','afichepublicidad8',
        'afichepublicidad9','afichepublicidad10','afichepublicidad11','afichepublicidad12',
        'afichepared1','afichepared2','afichepared3','afichepared4','afichepared5','afichepared6'
    ];

    foreach ($campos as $campo) {
        if ($request->has($campo)) {
            $publicidad->$campo = $request->input($campo);
        }
    }

    $publicidad->save();

    return response()->json([
        'message' => 'Publicidad actualizada correctamente',
        'data' => $publicidad
    ], 200);
}
}
