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
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellidos')->nullable();
            $table->string('telefono1')->nullable();
            $table->string('telefono2')->nullable();
            $table->unsignedBigInteger('cliente_id');
            $table->string('email')->unique()->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Añadir la columna `deleted_at` para el borrado lógico

            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactos');
    }
};
