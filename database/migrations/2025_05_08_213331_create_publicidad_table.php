<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('publicidad', function (Blueprint $table) {
            $table->id();
            $table->string('lobby_principal')->nullable();
            $table->string('lobby1')->nullable();
            $table->string('lobby2')->nullable();
            $table->string('lobby3')->nullable();
            $table->string('lobby4')->nullable();

            for ($i = 1; $i <= 12; $i++) {
                $table->string("afichepublicidad$i")->nullable();
            }

            for ($i = 1; $i <= 6; $i++) {
                $table->string("afichepared$i")->nullable();
            }

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publicidad');
    }
};
