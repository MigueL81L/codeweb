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
        Schema::create('courses', function (Blueprint $table) {
            //Campos propios de esta tabla
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            //1 Borrador, 2 Pendiente, 3 Publicado
            $table->integer('status')->default(1);
            $table->string('image_path')->nullable();
            $table->string('video_path')->nullable();
            $table->text('wellcome_message')->nullable();
            $table->text('goodbye_message')->nullable();
            $table->text('observation')->nullable();
            

            //Llaves foráneas
            $table->foreignId('user_id')->constrained();
            $table->foreignId('level_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('price_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
