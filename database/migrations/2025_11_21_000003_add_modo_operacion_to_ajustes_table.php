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
        Schema::table('ajustes', function (Blueprint $table) {
            $table->enum('modo_operacion', ['fichas', 'mesas'])->default('fichas')->after('id');
            $table->boolean('mostrar_usuarios')->default(true)->after('modo_operacion');
            $table->boolean('mostrar_gastos')->default(true)->after('mostrar_usuarios');
            $table->boolean('mostrar_compras')->default(true)->after('mostrar_gastos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ajustes', function (Blueprint $table) {
            $table->dropColumn(['modo_operacion', 'mostrar_usuarios', 'mostrar_gastos', 'mostrar_compras']);
        });
    }
};
