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
        Schema::create('fichas_productos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_ficha');
            $table->uuid('id_producto');
            $table->integer('cantidad');
            $table->decimal('precio', 10, 2);
            $table->timestamps();

            $table->foreign('id_ficha')->references('id')->on('fichas')->onDelete('cascade');
            $table->foreign('id_producto')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fichas_productos');
    }
};
