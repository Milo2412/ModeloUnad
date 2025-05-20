<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClicsRedesTable extends Migration
{
    public function up()
    {
        Schema::create('clics_redes', function (Blueprint $table) {
            $table->id();
            $table->string('visita_id')->nullable(); // anónimo
            $table->unsignedBigInteger('estante_id'); // ID del estante
            $table->string('red_social'); // ejemplo: instagram, facebook
            $table->timestamp('fecha')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('clics_redes');
    }
}