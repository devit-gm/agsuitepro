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
        Schema::create('ajustes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->decimal('precio_invitado', 10, 2);
            $table->integer('max_invitados_cobrar');
            $table->integer('primer_invitado_gratis');
            $table->integer('activar_invitados_grupo');
            $table->integer('permitir_comprar_sin_stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ajustes');
    }
};
