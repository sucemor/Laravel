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
        Schema::create('notas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('cuerpo');
            $table->unsignedBigInteger('cliente_id')->nullable(); // Añadir columna cliente_id
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Añadir la columna `deleted_at` para el borrado lógico

            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('set null'); // Añadir relación con clientes
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};
