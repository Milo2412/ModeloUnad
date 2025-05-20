<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClicRedSocialController extends Controller
{
    public function registrar(Request $request)
    {
        DB::table('clics_redes')->insert([
            'visita_id' => $request->visita_id ?? null,
            'estante_id' => $request->estante_id,
            'red_social' => $request->red_social,
            'fecha' => $request->fecha ?? now(),
        ]);

        return response()->json(['ok' => true]);
    }
}
