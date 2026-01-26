<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Personal;
use App\Models\Paciente;
use App\Models\Consulta;
use App\Models\Examen;
use App\Models\Tratamiento;
use Illuminate\Database\Seeder;

class AgregarDatosSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener doctores existentes
        $doctores = Personal::where('tipo', 'Doctor')->get();
        
        if ($doctores->isEmpty()) {
            $this->command->error('No hay doctores registrados');
            return;
        }

        // ==================== CREAR 50 PACIENTES ====================
        $pacientes = [];
        $nombres = ['María', 'Carlos', 'Ana', 'Pedro', 'Sandra', 'Jorge', 'Lucía', 'David', 'Isabel', 'Raúl', 
                   'Mariana', 'Esteban', 'Vanessa', 'Gustavo', 'Elena', 'Felipe', 'Catalina', 'Roberto', 'Marta', 'Julio',
                   'Sofía', 'Andrés', 'Patricia', 'Víctor', 'Alejandra', 'Fabio', 'Camila', 'Maximiliano', 'Daniela', 'Nicolás',
                   'Gabriela', 'Leonardo', 'Florencia', 'Sebastián', 'Rosario', 'Benjamin', 'Victoria', 'Armando', 'Verónica', 'Cristian',
                   'Mónica', 'Rodrigo', 'Adriana', 'Miguel', 'Esperanza', 'Alfonso', 'Leonor', 'Fernando', 'Irene', 'Guillermo'];
        
        $apellidos = ['González', 'Rodríguez', 'Martínez', 'López', 'Hernández', 'Fernández', 'Torres', 'García', 'Romero', 'Morales',
                     'Soto', 'Herrera', 'Chávez', 'Reyes', 'Ruiz', 'Domínguez', 'Mendoza', 'Bravo', 'Parra', 'Vargas',
                     'Cruz', 'Silva', 'Flores', 'Montoya', 'Ramos', 'Muñoz', 'Vega', 'Ortiz', 'Ramírez', 'Fuentes',
                     'Jiménez', 'Gutiérrez', 'Castro', 'Navarro', 'Sánchez', 'Maldonado', 'Cordero', 'Rosales', 'Iglesias', 'Moreno',
                     'Ponce', 'Vásquez', 'Reyes', 'Peña', 'Carrasco', 'González', 'Medina', 'Herrera', 'Valencia', 'Salinas'];
        
        $grupos_sangre = ['O+', 'A+', 'B+', 'AB+', 'O-', 'A-', 'B-', 'AB-'];
        $alergias_list = [null, 'Penicilina', 'Aspirina', 'Ibuprofeno', 'Antibióticos', 'Sulfonamidas'];
        $enfermedades = [null, 'Hipertensión', 'Diabetes', 'Asma', 'Colesterol', 'Gastritis', 'Artrosis', 'Migraña'];

        // Obtener el DNI máximo actual
        $maxDni = Paciente::max('dni');
        $nextDniBase = $maxDni ? intval($maxDni) + 1 : 20000001;

        for ($i = 1; $i <= 50; $i++) {
            $pacientes[] = Paciente::create([
                'nombre' => $nombres[$i - 1],
                'apellido' => $apellidos[$i - 1],
                'dni' => (string)($nextDniBase + $i),
                'fecha_nacimiento' => now()->subYears(rand(20, 70))->format('Y-m-d'),
                'genero' => rand(0, 1) ? 'M' : 'F',
                'telefono' => '91' . rand(10000000, 99999999),
                'email' => strtolower($nombres[$i - 1]) . 'n' . $i . '@example.com',
                'direccion' => 'Calle ' . rand(1, 200),
                'grupo_sanguineo' => $grupos_sangre[rand(0, 7)],
                'alergias' => $alergias_list[rand(0, 5)],
                'enfermedades_cronicas' => $enfermedades[rand(0, 7)],
            ]);
        }

        $this->command->line('✓ 50 Pacientes creados');

        // ==================== CREAR CONSULTAS (Con al menos 10) ====================
        $consultas = [];
        foreach ($pacientes as $idx => $paciente) {
            $doctor = $doctores[$idx % $doctores->count()];
            
            // 1-3 consultas por paciente
            for ($j = 0; $j < rand(1, 3); $j++) {
                $motivos = ['Revisión general', 'Control de presión', 'Chequeo', 'Seguimiento', 'Dolor', 'Fiebre', 'Malestares'];
                $fecha = now()->subDays(rand(0, 60));
                
                $consultas[] = Consulta::create([
                    'paciente_id' => $paciente->id,
                    'doctor_id' => $doctor->id,
                    'fecha_hora' => $fecha->setTime(rand(8, 17), rand(0, 59)),
                    'motivo' => $motivos[rand(0, 6)],
                    'diagnostico' => rand(0, 1) ? 'Paciente estable' : 'Requiere seguimiento',
                    'observaciones' => rand(0, 1) ? 'Continuar tratamiento' : null,
                    'estado' => ['Concluida', 'Concluida', 'En Proceso', 'Pendiente'][rand(0, 3)],
                    'costo' => rand(100, 250),
                ]);
            }
        }

        $this->command->line('✓ ' . count($consultas) . ' Consultas creadas');

        // ==================== CREAR EXÁMENES PENDIENTES (Con al menos 10) ====================
        $examenesCount = 0;
        foreach ($pacientes as $idx => $paciente) {
            if ($examenesCount < 15) {
                $doctor = $doctores[$idx % $doctores->count()];
                $tipos_examen = ['Análisis de sangre', 'Radiografía', 'Electrocardiograma', 'Ultrasonido', 'Tomografía', 'Resonancia'];
                
                for ($j = 0; $j < 2 && $examenesCount < 15; $j++) {
                    $consulta = $consultas[rand(0, count($consultas) - 1)] ?? null;
                    
                    Examen::create([
                        'paciente_id' => $paciente->id,
                        'consulta_id' => $consulta?->id,
                        'solicitado_por' => $doctor->id,
                        'tipo_examen' => $tipos_examen[rand(0, 5)],
                        'descripcion' => 'Examen de control',
                        'fecha_solicitud' => now(),
                        'fecha_realizacion' => null,
                        'resultados' => null,
                        'estado' => 'Solicitado',
                        'costo' => rand(80, 150),
                    ]);
                    $examenesCount++;
                }
            }
        }

        $this->command->line('✓ ' . $examenesCount . ' Exámenes pendientes creados');

        // ==================== CREAR TRATAMIENTOS ACTIVOS (Con al menos 10) ====================
        $tratamientosCount = 0;
        foreach ($pacientes as $idx => $paciente) {
            if ($tratamientosCount < 15) {
                $doctor = $doctores[$idx % $doctores->count()];
                $medicamentos = ['Enalapril 10mg', 'Metformina 500mg', 'Salbutamol', 'Simvastatina', 'Ranitidina', 'Ibuprofeno'];
                
                for ($j = 0; $j < 1 && $tratamientosCount < 15; $j++) {
                    $consulta = $consultas[rand(0, count($consultas) - 1)] ?? null;
                    
                    Tratamiento::create([
                        'paciente_id' => $paciente->id,
                        'consulta_id' => $consulta?->id,
                        'doctor_id' => $doctor->id,
                        'nombre_tratamiento' => 'Tratamiento ' . ($tratamientosCount + 1),
                        'descripcion' => 'Tratamiento médico activo',
                        'medicamentos' => $medicamentos[rand(0, 5)] . ' c/12h',
                        'indicaciones' => 'Tomar con alimentos',
                        'fecha_inicio' => now()->subDays(rand(5, 30)),
                        'fecha_fin' => now()->addDays(rand(30, 90)),
                        'estado' => 'En Proceso',
                        'costo' => rand(150, 400),
                    ]);
                    $tratamientosCount++;
                }
            }
        }

        $this->command->line('✓ ' . $tratamientosCount . ' Tratamientos activos creados');

        // ==================== CREAR CONSULTAS DE HOY (Con al menos 10) ====================
        $consultasHoy = 0;
        foreach ($pacientes as $idx => $paciente) {
            if ($consultasHoy < 12) {
                $doctor = $doctores[$idx % $doctores->count()];
                $motivos = ['Control rutinario', 'Seguimiento', 'Revisión', 'Chequeo', 'Evaluación'];
                
                Consulta::create([
                    'paciente_id' => $paciente->id,
                    'doctor_id' => $doctor->id,
                    'fecha_hora' => now()->setTime(rand(8, 17), rand(0, 59)),
                    'motivo' => $motivos[rand(0, 4)],
                    'diagnostico' => null,
                    'observaciones' => null,
                    'estado' => rand(0, 1) ? 'En Proceso' : 'Pendiente',
                    'costo' => rand(100, 250),
                ]);
                $consultasHoy++;
            }
        }

        $this->command->line('✓ ' . $consultasHoy . ' Consultas de hoy creadas');

        // ==================== MENSAJES ====================
        $this->command->info('');
        $this->command->info('═══════════════════════════════════════════════════════');
        $this->command->info('✓ DATOS MASIVOS AGREGADOS EXITOSAMENTE');
        $this->command->info('═══════════════════════════════════════════════════════');
        $this->command->line('');
        $this->command->info('📊 RESUMEN DE DATOS AGREGADOS:');
        $this->command->line('  • 50 Pacientes nuevos');
        $this->command->line('  • ' . count($consultas) . ' Consultas totales');
        $this->command->line('  • ' . $examenesCount . ' Exámenes pendientes');
        $this->command->line('  • ' . $tratamientosCount . ' Tratamientos activos');
        $this->command->line('  • ' . $consultasHoy . ' Consultas de hoy');
        $this->command->line('');
        $this->command->info('═══════════════════════════════════════════════════════');
    }
}
