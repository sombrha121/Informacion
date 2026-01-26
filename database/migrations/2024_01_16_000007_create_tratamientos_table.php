<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tratamientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->foreignId('consulta_id')->nullable()->constrained('consultas')->onDelete('set null');
            $table->foreignId('doctor_id')->constrained('personal')->onDelete('cascade');
            $table->string('nombre_tratamiento');
            $table->text('descripcion');
            $table->text('medicamentos')->nullable();
            $table->text('indicaciones')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->enum('estado', ['Pendiente', 'En Proceso', 'Completado', 'Cancelado'])->default('Pendiente');
            $table->decimal('costo', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tratamientos');
    }
};
