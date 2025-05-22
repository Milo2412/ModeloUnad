<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- Esta línea es esencial

class DashboardController extends Controller
{
public function general()
{
    $entradasLobby = DB::table('zonas_visitadas')->where('zona', 'Lobby')->count();
    $usuariosUnicos = DB::table('duracion_zonas')->distinct('visita_id')->count('visita_id');
    $zonas = DB::table('duracion_zonas')
                ->select('zona', DB::raw('COUNT(*) as visitas'))
                ->groupBy('zona')->get();
    $clicksRedes = DB::table('clics_redes')->count();
    $comparacionZonas = DB::table('duracion_zonas')
                ->select('zona', DB::raw('ROUND(AVG(TIMESTAMPDIFF(SECOND, entrada, salida)),2) as tiempo_promedio'))
                ->whereNotNull('salida')
                ->groupBy('zona')->get();

    return response()->json([
        'entradasLobby' => $entradasLobby,
        'usuariosUnicos' => $usuariosUnicos,
        'zonas' => $zonas,
        'clicksRedes' => $clicksRedes,
        'comparacionZonas' => $comparacionZonas,
    ]);
}

public function porEstante($id)
{
    $nombreZona = 'Estante_' . $id;

    $clicks = DB::table('clics_redes')
                ->select('red_social', DB::raw('COUNT(*) as total'))
                ->where('estante_id', $id)
                ->groupBy('red_social')->get();

    $vistas = DB::table('duracion_zonas')->where('zona', $nombreZona)->count();

    $tiempo = DB::table('duracion_zonas')
                ->where('zona', $nombreZona)
                ->whereNotNull('salida')
                ->select(DB::raw('ROUND(AVG(TIMESTAMPDIFF(SECOND, entrada, salida)),2) as promedio'))
                ->first();

    return response()->json([
        'estante_id' => $id,
        'clicksRedes' => $clicks,
        'vistas' => $vistas,
        'tiempoPromedio' => $tiempo->promedio ?? 0,
    ]);
}
}
