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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['Llamada', 'Pago', 'Revisión']);
            $table->string('titulo');
            $table->enum('estado', ['Pendiente', 'Cancelado', 'Terminado']);
            $table->timestamp('fecha_fin')->nullable();
            $table->timestamp('fecha_aviso')->nullable();
            $table->timestamps(); // Esto crea las columnas `created_at` y `updated_at`
            $table->text('descripcion')->nullable();
            $table->softDeletes(); // Añadir la columna `deleted_at` para el borrado lógico
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->unsignedBigInteger('user_id'); // Añadir el campo user_id

            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Crear la relación con la tabla users
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
