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
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id'); // ID del sitio al que pertenece la licencia
            $table->unsignedBigInteger('user_id'); // ID del usuario al que pertenece la licencia
            $table->string('license_key')->unique();
            $table->date('expires_at');
            $table->timestamps();

            $table->foreign('site_id')->references('id')->on('sitios')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
