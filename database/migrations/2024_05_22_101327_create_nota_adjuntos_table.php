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
        // Verificar si la tabla no existe antes de crearla
        if (!Schema::hasTable('nota_adjuntos')) {
            Schema::create('nota_adjuntos', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('nota_id');
                $table->string('archivo');
                $table->timestamps();
                $table->softDeletes();

                $table->foreign('nota_id')->references('id')->on('notas')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_adjuntos');
    }
};
