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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('telefono1', 16)->nullable();
            $table->string('telefono2', 16)->nullable();
            $table->string('tipo_empresa', 20)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('web')->nullable();
            $table->string('direccion')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('provincia')->nullable();
            $table->string('pais')->nullable();
            $table->string('codigo_postal', 5)->nullable();
            $table->text('observaciones')->nullable();
            $table->enum('estado', ['contactar', 'posible', 'acuerdo', 'terminado', 'cancelado'])->default('contactar');
            $table->timestamps();
            $table->softDeletes(); // Añadir la columna `deleted_at` para el borrado lógico

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
