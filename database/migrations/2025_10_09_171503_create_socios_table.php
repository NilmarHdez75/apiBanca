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
        Schema::create('socios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('numero_socio')->unique();
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->enum('sexo', ['M', 'F']);
            $table->date('fecha_nacimiento');
            $table->string('nacionalidad');
            $table->string('curp')->nullable()->unique();
            $table->string('rfc')->nullable()->unique();
            $table->string('ine')->nullable()->unique();
            $table->string('telefono')->nullable();
            $table->foreignId('id_sucursal')->constrained('sucursales')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('socios');
    }
};
