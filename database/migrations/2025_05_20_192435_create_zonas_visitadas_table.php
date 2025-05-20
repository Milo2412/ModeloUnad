<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZonasVisitadasTable extends Migration
{
    public function up()
    {
        Schema::create('zonas_visitadas', function (Blueprint $table) {
            $table->id();
            $table->string('zona'); // nombre de la zona, ej: Lobby, Estante_12
            $table->string('visita_id')->nullable(); // identificador anónimo
            $table->ipAddress('ip')->nullable(); // respaldo de IP
            $table->timestamp('fecha')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('zonas_visitadas');
    }
}