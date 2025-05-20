<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDuracionZonasTable extends Migration
{
    public function up()
    {
        Schema::create('duracion_zonas', function (Blueprint $table) {
            $table->id();
            $table->string('zona');
            $table->string('visita_id')->nullable();
            $table->timestamp('entrada');
            $table->timestamp('salida')->nullable();
            $table->timestamps(); // created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('duracion_zonas');
    }
}

