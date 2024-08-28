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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');

            // 1 significa video normal, 2 video de youtube
            $table->integer('platform');

            // Indica donde subir el video
            $table->string('video_path')->nullable();

            // Nombre original video, antes de subirlo
            $table->string('video_original_name')->nullable();

            // Almacena la imagen de la lección
            $table->string('image_path')->nullable();

            // Añadir el nuevo campo para el nombre original del documento
            $table->string('document_original_name')->nullable(); // Agregar este campo

            $table->text('description')->nullable();
            $table->string('document_path')->nullable(); 
            $table->integer('duration')->nullable();
            $table->integer('position');

            // Las lecciones subidas, se considerarán publicadas por defecto
            $table->boolean('is_published')->default(1);
            $table->boolean('is_preview')->default(0);
            $table->boolean('is_processed')->default(0);

            // Llave foránea de section
            $table->foreignId('section_id')
                    ->constrained()
                    ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};


