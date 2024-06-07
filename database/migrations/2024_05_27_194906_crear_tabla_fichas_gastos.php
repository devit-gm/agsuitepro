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
        Schema::create('fichas_gastos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_ficha');
            $table->unsignedBigInteger('user_id');
            $table->string('descripcion');
            $table->string('ticket');
            $table->decimal('precio', 10, 2);
            $table->timestamps();

            $table->foreign('id_ficha')->references('id')->on('fichas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fichas_gastos');
    }
};
