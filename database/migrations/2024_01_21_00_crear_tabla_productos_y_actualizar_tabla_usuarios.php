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
        Schema::create('productos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nombre');
            $table->string('imagen');
            $table->integer('posicion');
            $table->uuid('familia');
            $table->integer('combinado');
            $table->decimal('precio');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        schema::dropIfExists('productos');
    }
};
