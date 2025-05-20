<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DuracionZonaController extends Controller
{
    // Registra la entrada a una zona
    public function registrarEntrada(Request $request)
    {
        $request->validate([
            'zona' => 'required|string',
            'visita_id' => 'nullable|string',
            'entrada' => 'nullable|date',
        ]);

        $entrada = $request->entrada ? $request->entrada : now();

        // Insertar registro de entrada con salida NULL
        $id = DB::table('duracion_zonas')->insertGetId([
            'zona' => $request->zona,
            'visita_id' => $request->visita_id,
            'entrada' => $entrada,
            'salida' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['ok' => true, 'registro_id' => $id]);
    }

    // Registra la salida de una zona actualizando el registro de entrada
    public function registrarSalida(Request $request)
    {
        $request->validate([
            'registro_id' => 'required|integer',
            'salida' => 'nullable|date',
        ]);

        $salida = $request->salida ? $request->salida : now();

        $actualizado = DB::table('duracion_zonas')
            ->where('id', $request->registro_id)
            ->whereNull('salida')
            ->update([
                'salida' => $salida,
                'updated_at' => now(),
            ]);

        if ($actualizado) {
            return response()->json(['ok' => true]);
        } else {
            return response()->json(['ok' => false, 'error' => 'Registro no encontrado o ya cerrado'], 404);
        }
    }
}
