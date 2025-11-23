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
        Schema::create('mesa_historial', function (Blueprint $table) {
            $table->id();
            $table->char('mesa_id', 36);
            $table->enum('accion', ['abrir', 'tomar', 'añadir_consumo', 'cerrar', 'liberar']);
            $table->unsignedBigInteger('camarero_id');
            $table->unsignedBigInteger('camarero_anterior_id')->nullable();
            $table->json('detalles')->nullable();
            $table->dateTime('fecha_accion')->useCurrent();
            
            // Foreign keys
            $table->foreign('mesa_id')->references('uuid')->on('fichas')->onDelete('cascade');
            $table->foreign('camarero_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('camarero_anterior_id')->references('id')->on('users')->onDelete('set null');
            
            // Índices
            $table->index('mesa_id');
            $table->index('fecha_accion');
            $table->index('camarero_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesa_historial');
    }
};
