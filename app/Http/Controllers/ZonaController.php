<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ZonaController extends Controller
{
    public function registrar(Request $request)
    {
        DB::table('zonas_visitadas')->insert([
            'zona' => $request->zona,
            'user_id' => $request->user_id ?? null,
            'ip' => $request->ip(),
            'fecha' => $request->fecha,
        ]);

        return response()->json(['ok' => true]);
    }
}
