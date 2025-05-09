<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstantesSeeder extends Seeder
{
    public function run()
    {
        $estantes = [];

        for ($i = 0; $i < 30; $i++) {
            $estantes[] = [
                'user_id' => null,
                'whatsapp' => null,
                'facebook' => null,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('estantes')->insert($estantes);
    }
}
