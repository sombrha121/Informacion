<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('examenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->foreignId('consulta_id')->nullable()->constrained('consultas')->onDelete('set null');
            $table->foreignId('solicitado_por')->constrained('personal')->onDelete('cascade');
            $table->string('tipo_examen');
            $table->text('descripcion')->nullable();
            $table->dateTime('fecha_solicitud');
            $table->dateTime('fecha_realizacion')->nullable();
            $table->text('resultados')->nullable();
            $table->enum('estado', ['Solicitado', 'En Proceso', 'Concluido', 'Cancelado'])->default('Solicitado');
            $table->decimal('costo', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('examenes');
    }
};
