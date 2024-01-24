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
            $table->id();
            $table->string('nombre');
            $table->string('imagen');
            $table->integer('posicion');
            $table->integer('familia');
            $table->integer('combinado');
            $table->decimal('precio');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('image')->after('email');
            $table->integer('role_id')->after('image');
            $table->string('phone_number')->after('role_id');
        });
    }
};
