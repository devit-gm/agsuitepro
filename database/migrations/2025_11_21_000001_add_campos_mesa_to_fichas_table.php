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
        Schema::table('fichas', function (Blueprint $table) {
            $table->string('numero_mesa', 10)->nullable()->after('nombre');
            $table->integer('numero_comensales')->default(1)->after('numero_mesa');
            $table->enum('modo', ['ficha', 'mesa'])->default('ficha')->after('numero_comensales');
            $table->enum('estado_mesa', ['libre', 'ocupada', 'cerrada'])->default('libre')->after('modo');
            $table->unsignedBigInteger('camarero_id')->nullable()->after('user_id');
            $table->dateTime('hora_apertura')->nullable()->after('hora');
            $table->dateTime('hora_cierre')->nullable()->after('hora_apertura');
            $table->unsignedBigInteger('ultimo_camarero_id')->nullable()->after('camarero_id');
            
            // Índices
            $table->index('estado_mesa');
            $table->index('camarero_id');
            $table->index('numero_mesa');
            
            // Foreign keys
            $table->foreign('camarero_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('ultimo_camarero_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fichas', function (Blueprint $table) {
            $table->dropForeign(['camarero_id']);
            $table->dropForeign(['ultimo_camarero_id']);
            $table->dropIndex(['estado_mesa']);
            $table->dropIndex(['camarero_id']);
            $table->dropIndex(['numero_mesa']);
            $table->dropColumn([
                'numero_mesa',
                'numero_comensales',
                'modo',
                'estado_mesa',
                'camarero_id',
                'hora_apertura',
                'hora_cierre',
                'ultimo_camarero_id'
            ]);
        });
    }
};
