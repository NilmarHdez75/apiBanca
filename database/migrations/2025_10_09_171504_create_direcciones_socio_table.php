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
        Schema::create('direcciones_socio', function (Blueprint $table) {
            $table->id('id_direccion');
            $table->foreignId('id_socio')->constrained('socios')->onUpdate('cascade')->onDelete('cascade');
            $table->string('calle');
            $table->string('numero_ext');
            $table->string('numero_int')->nullable();
            $table->string('colonia');
            $table->string('municipio');
            $table->string('estado');
            $table->string('cp');
            $table->string('pais');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direcciones_socio');
    }
};
