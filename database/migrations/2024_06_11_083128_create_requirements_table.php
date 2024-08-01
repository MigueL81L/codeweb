<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('requirements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            //Parámetro que me permitirá relacionar curso y meta, llave foránea
            $table  ->foreignId('course_id')
                    ->constrained()
                    ->onDelete('cascade');

            //Campo creado estrictamente para almacenar la posición en la que está una meta, de 
            //modo que si se cambia dicha posición, se anote dicho cambio en la bbdd
            $table->integer('position'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requirements');
    }
};
