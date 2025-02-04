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
        Schema::create('registros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('persona')->nullable();
            $table->unsignedBigInteger('activo')->nullable();
            $table->enum('tipo_cambio', ['ASIGNACION', 'DESVINCULACION','CREADO','MODIFICADO']);
            $table->unsignedBigInteger('encargado_cambio');
            $table->timestamps();

            $table->foreign('persona')->references('id')->on('personas')->onDelete('set null');
            $table->foreign('activo')->references('id')->on('activos')->onDelete('set null');
            $table->foreign('encargado_cambio')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros');
    }
};
