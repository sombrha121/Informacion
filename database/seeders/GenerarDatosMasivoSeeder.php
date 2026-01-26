<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Personal;
use App\Models\Paciente;
use App\Models\Consulta;
use App\Models\Examen;
use App\Models\Tratamiento;
use App\Models\Compra;
use App\Models\DetalleCompra;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GenerarDatosMasivoSeeder extends Seeder
{
    public function run(): void
    {
        // ==================== DOCTORES ====================
        $doctores = [];
        
        $doctor1 = User::create([
            'name' => 'Dr. Juan Pérez',
            'email' => 'doctor1@sistema.com',
            'password' => Hash::make('doctor123'),
        ]);
        $doctores[] = Personal::create([
            'user_id' => $doctor1->id,
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'dni' => '99999001',
            'tipo' => 'Doctor',
            'especialidad' => 'Medicina General',
            'telefono' => '987654321',
            'email' => 'doctor1@sistema.com',
            'fecha_contratacion' => now()->subYears(3),
            'estado' => 'Activo',
        ]);

        $doctor2 = User::create([
            'name' => 'Dra. María García',
            'email' => 'doctor2@sistema.com',
            'password' => Hash::make('doctor123'),
        ]);
        $doctores[] = Personal::create([
            'user_id' => $doctor2->id,
            'nombre' => 'María',
            'apellido' => 'García',
            'dni' => '99999002',
            'tipo' => 'Doctor',
            'especialidad' => 'Cardiología',
            'telefono' => '987654322',
            'email' => 'doctor2@sistema.com',
            'fecha_contratacion' => now()->subYears(2),
            'estado' => 'Activo',
        ]);

        $doctor3 = User::create([
            'name' => 'Dr. Luis Martínez',
            'email' => 'doctor3@sistema.com',
            'password' => Hash::make('doctor123'),
        ]);
        $doctores[] = Personal::create([
            'user_id' => $doctor3->id,
            'nombre' => 'Luis',
            'apellido' => 'Martínez',
            'dni' => '99999003',
            'tipo' => 'Doctor',
            'especialidad' => 'Pediatría',
            'telefono' => '987654323',
            'email' => 'doctor3@sistema.com',
            'fecha_contratacion' => now()->subYears(1),
            'estado' => 'Activo',
        ]);

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

        for ($i = 1; $i <= 50; $i++) {
            $pacientes[] = Paciente::create([
                'nombre' => $nombres[$i - 1],
                'apellido' => $apellidos[$i - 1],
                'dni' => '20000' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'fecha_nacimiento' => now()->subYears(rand(20, 70))->format('Y-m-d'),
                'genero' => rand(0, 1) ? 'M' : 'F',
                'telefono' => '91' . rand(10000000, 99999999),
                'email' => strtolower($nombres[$i - 1]) . $i . '@example.com',
                'direccion' => 'Calle ' . rand(1, 200),
                'grupo_sanguineo' => $grupos_sangre[rand(0, 7)],
                'alergias' => $alergias_list[rand(0, 5)],
                'enfermedades_cronicas' => $enfermedades[rand(0, 7)],
            ]);
        }

        // ==================== CREAR CONSULTAS (Con al menos 10) ====================
        $consultas = [];
        foreach ($pacientes as $idx => $paciente) {
            $doctor = $doctores[($idx % 3)];
            
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

        // ==================== CREAR EXÁMENES PENDIENTES (Con al menos 10) ====================
        $examenesCount = 0;
        foreach ($pacientes as $idx => $paciente) {
            if ($examenesCount < 15) {
                $doctor = $doctores[($idx % 3)];
                $tipos_examen = ['Análisis de sangre', 'Radiografía', 'Electrocardiograma', 'Ultrasonido', 'Tomografía', 'Resonancia'];
                
                for ($j = 0; $j < 2 && $examenesCount < 15; $j++) {
                    Examen::create([
                        'paciente_id' => $paciente->id,
                        'consulta_id' => $consultas[rand(0, count($consultas) - 1)]->id ?? null,
                        'solicitado_por' => $doctor->id,
                        'tipo_examen' => $tipos_examen[rand(0, 5)],
                        'descripcion' => 'Examen de control',
                        'fecha_solicitud' => now(),
                        'fecha_realizacion' => null,
                        'resultados' => null,
                        'estado' => 'Pendiente',
                        'costo' => rand(80, 150),
                    ]);
                    $examenesCount++;
                }
            }
        }

        // ==================== CREAR TRATAMIENTOS ACTIVOS (Con al menos 10) ====================
        $tratamientosCount = 0;
        foreach ($pacientes as $idx => $paciente) {
            if ($tratamientosCount < 15) {
                $doctor = $doctores[($idx % 3)];
                $medicamentos = ['Enalapril 10mg', 'Metformina 500mg', 'Salbutamol', 'Simvastatina', 'Ranitidina', 'Ibuprofeno'];
                
                for ($j = 0; $j < 1 && $tratamientosCount < 15; $j++) {
                    Tratamiento::create([
                        'paciente_id' => $paciente->id,
                        'consulta_id' => $consultas[rand(0, count($consultas) - 1)]->id ?? null,
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

        // ==================== CREAR CONSULTAS DE HOY (Con al menos 10) ====================
        $consultasHoy = 0;
        foreach ($pacientes as $idx => $paciente) {
            if ($consultasHoy < 12) {
                $doctor = $doctores[($idx % 3)];
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

        // ==================== MENSAJES ====================
        $this->command->info('═══════════════════════════════════════════════════════');
        $this->command->info('✓ DATOS MASIVOS CREADOS EXITOSAMENTE');
        $this->command->info('═══════════════════════════════════════════════════════');
        $this->command->line('');
        $this->command->info('📊 RESUMEN:');
        $this->command->line('  • 50 Pacientes nuevos');
        $this->command->line('  • ' . count($consultas) . ' Consultas totales');
        $this->command->line('  • ' . $examenesCount . ' Exámenes pendientes');
        $this->command->line('  • ' . $tratamientosCount . ' Tratamientos activos');
        $this->command->line('  • ' . $consultasHoy . ' Consultas de hoy');
        $this->command->line('');
        $this->command->info('═══════════════════════════════════════════════════════');
    }
}
