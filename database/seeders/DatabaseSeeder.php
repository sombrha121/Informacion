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

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==================== USUARIOS Y PERSONAL ====================
        
        // Crear usuario administrador
        $admin = User::create([
            'name' => 'Administrador Sistema',
            'email' => 'admin@sistema.com',
            'password' => Hash::make('admin123'),
        ]);

        Personal::create([
            'user_id' => $admin->id,
            'nombre' => 'Administrador',
            'apellido' => 'Sistema',
            'dni' => '00000000',
            'tipo' => 'Administrativo',
            'especialidad' => null,
            'telefono' => '999999999',
            'email' => 'admin@sistema.com',
            'fecha_contratacion' => now()->subYears(2),
            'estado' => 'Activo',
        ]);

        // Crear doctores
        $doctor1 = User::create([
            'name' => 'Dr. Juan Pérez',
            'email' => 'doctor1@sistema.com',
            'password' => Hash::make('doctor123'),
        ]);

        $personalDoctor1 = Personal::create([
            'user_id' => $doctor1->id,
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'dni' => '12345678',
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

        $personalDoctor2 = Personal::create([
            'user_id' => $doctor2->id,
            'nombre' => 'María',
            'apellido' => 'García',
            'dni' => '87654321',
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

        $personalDoctor3 = Personal::create([
            'user_id' => $doctor3->id,
            'nombre' => 'Luis',
            'apellido' => 'Martínez',
            'dni' => '23456789',
            'tipo' => 'Doctor',
            'especialidad' => 'Pediatría',
            'telefono' => '987654323',
            'email' => 'doctor3@sistema.com',
            'fecha_contratacion' => now()->subYears(1),
            'estado' => 'Activo',
        ]);

        // Crear enfermeros
        $nurse1 = User::create([
            'name' => 'Enfermero Roberto',
            'email' => 'enfermero1@sistema.com',
            'password' => Hash::make('enfermero123'),
        ]);

        Personal::create([
            'user_id' => $nurse1->id,
            'nombre' => 'Roberto',
            'apellido' => 'Sánchez',
            'dni' => '34567890',
            'tipo' => 'Enfermero',
            'especialidad' => 'Enfermería General',
            'telefono' => '987654324',
            'email' => 'enfermero1@sistema.com',
            'fecha_contratacion' => now()->subMonths(8),
            'estado' => 'Activo',
        ]);

        // ==================== PACIENTES ====================
        
        $paciente1 = Paciente::create([
            'nombre' => 'María',
            'apellido' => 'González',
            'dni' => '45678901',
            'fecha_nacimiento' => '1990-05-15',
            'genero' => 'F',
            'telefono' => '965432178',
            'email' => 'maria@example.com',
            'direccion' => 'Av. Principal 123',
            'grupo_sanguineo' => 'O+',
            'alergias' => 'Penicilina',
            'enfermedades_cronicas' => 'Hipertensión',
        ]);

        $paciente2 = Paciente::create([
            'nombre' => 'Carlos',
            'apellido' => 'Rodríguez',
            'dni' => '78901234',
            'fecha_nacimiento' => '1985-08-20',
            'genero' => 'M',
            'telefono' => '912345678',
            'email' => 'carlos@example.com',
            'direccion' => 'Calle Los Olivos 456',
            'grupo_sanguineo' => 'A+',
            'alergias' => null,
            'enfermedades_cronicas' => 'Diabetes tipo 2',
        ]);

        $paciente3 = Paciente::create([
            'nombre' => 'Ana',
            'apellido' => 'Martínez',
            'dni' => '56789012',
            'fecha_nacimiento' => '1995-12-10',
            'genero' => 'F',
            'telefono' => '934567890',
            'email' => 'ana@example.com',
            'direccion' => 'Jr. Las Flores 789',
            'grupo_sanguineo' => 'B+',
            'alergias' => 'Aspirina',
            'enfermedades_cronicas' => null,
        ]);

        $paciente4 = Paciente::create([
            'nombre' => 'Pedro',
            'apellido' => 'López',
            'dni' => '89012345',
            'fecha_nacimiento' => '2010-03-22',
            'genero' => 'M',
            'telefono' => '956789012',
            'email' => 'pedro@example.com',
            'direccion' => 'Av. Libertad 321',
            'grupo_sanguineo' => 'AB+',
            'alergias' => null,
            'enfermedades_cronicas' => null,
        ]);

        $paciente5 = Paciente::create([
            'nombre' => 'Sandra',
            'apellido' => 'Hernández',
            'dni' => '67890123',
            'fecha_nacimiento' => '1988-11-07',
            'genero' => 'F',
            'telefono' => '978901234',
            'email' => 'sandra@example.com',
            'direccion' => 'Jr. Central 654',
            'grupo_sanguineo' => 'O-',
            'alergias' => 'Antibióticos',
            'enfermedades_cronicas' => 'Asma',
        ]);

        // ==================== CONSULTAS ====================
        
        $consulta1 = Consulta::create([
            'paciente_id' => $paciente1->id,
            'doctor_id' => $personalDoctor1->id,
            'fecha_hora' => now()->subDays(5)->setTime(10, 30),
            'motivo' => 'Revisión de presión arterial',
            'diagnostico' => 'Hipertensión controlada',
            'observaciones' => 'Continuar con medicación actual',
            'estado' => 'Concluida',
            'costo' => 150.00,
        ]);

        $consulta2 = Consulta::create([
            'paciente_id' => $paciente2->id,
            'doctor_id' => $personalDoctor1->id,
            'fecha_hora' => now()->subDays(3)->setTime(14, 0),
            'motivo' => 'Control de diabetes',
            'diagnostico' => 'Diabetes tipo 2 estable',
            'observaciones' => 'Mantener dieta y ejercicio',
            'estado' => 'Concluida',
            'costo' => 150.00,
        ]);

        $consulta3 = Consulta::create([
            'paciente_id' => $paciente3->id,
            'doctor_id' => $personalDoctor2->id,
            'fecha_hora' => now()->subDays(1)->setTime(9, 0),
            'motivo' => 'Chequeo cardiaco de rutina',
            'diagnostico' => 'Sin anomalías cardíacas',
            'observaciones' => 'Corazón sano, continuar con rutina',
            'estado' => 'Concluida',
            'costo' => 200.00,
        ]);

        $consulta4 = Consulta::create([
            'paciente_id' => $paciente4->id,
            'doctor_id' => $personalDoctor3->id,
            'fecha_hora' => now()->setTime(11, 0),
            'motivo' => 'Revisión periódica infantil',
            'diagnostico' => 'Niño sano',
            'observaciones' => 'Desarrollo normal',
            'estado' => 'En Proceso',
            'costo' => 100.00,
        ]);

        $consulta5 = Consulta::create([
            'paciente_id' => $paciente5->id,
            'doctor_id' => $personalDoctor1->id,
            'fecha_hora' => now()->addDays(2)->setTime(15, 30),
            'motivo' => 'Control de asma',
            'diagnostico' => null,
            'observaciones' => null,
            'estado' => 'Pendiente',
            'costo' => 120.00,
        ]);

        // ==================== EXÁMENES ====================
        
        $examen1 = Examen::create([
            'paciente_id' => $paciente1->id,
            'consulta_id' => $consulta1->id,
            'solicitado_por' => $personalDoctor1->id,
            'tipo_examen' => 'Análisis de sangre',
            'descripcion' => 'Perfil completo de sangre',
            'fecha_solicitud' => $consulta1->fecha_hora,
            'fecha_realizacion' => now()->subDays(4),
            'resultados' => 'Glucosa: 95 mg/dl, Colesterol: 180 mg/dl',
            'estado' => 'Concluido',
            'costo' => 80.00,
        ]);

        $examen2 = Examen::create([
            'paciente_id' => $paciente2->id,
            'consulta_id' => $consulta2->id,
            'solicitado_por' => $personalDoctor1->id,
            'tipo_examen' => 'Hemoglobina A1c',
            'descripcion' => 'Control de diabetes',
            'fecha_solicitud' => $consulta2->fecha_hora,
            'fecha_realizacion' => now()->subDays(2),
            'resultados' => 'HbA1c: 7.2%',
            'estado' => 'Concluido',
            'costo' => 60.00,
        ]);

        $examen3 = Examen::create([
            'paciente_id' => $paciente3->id,
            'consulta_id' => $consulta3->id,
            'solicitado_por' => $personalDoctor2->id,
            'tipo_examen' => 'Electrocardiograma',
            'descripcion' => 'ECG de rutina',
            'fecha_solicitud' => $consulta3->fecha_hora,
            'fecha_realizacion' => now()->subDays(1),
            'resultados' => 'Ritmo normal, sin anomalías',
            'estado' => 'Concluido',
            'costo' => 120.00,
        ]);

        $examen4 = Examen::create([
            'paciente_id' => $paciente4->id,
            'consulta_id' => $consulta4->id,
            'solicitado_por' => $personalDoctor3->id,
            'tipo_examen' => 'Radiografía de tórax',
            'descripcion' => 'Control pediátrico',
            'fecha_solicitud' => now(),
            'fecha_realizacion' => null,
            'resultados' => null,
            'estado' => 'En Proceso',
            'costo' => 100.00,
        ]);

        // ==================== TRATAMIENTOS ====================
        
        $tratamiento1 = Tratamiento::create([
            'paciente_id' => $paciente1->id,
            'consulta_id' => $consulta1->id,
            'doctor_id' => $personalDoctor1->id,
            'nombre_tratamiento' => 'Control de Hipertensión',
            'descripcion' => 'Tratamiento farmacológico para controlar la presión arterial',
            'medicamentos' => 'Enalapril 10mg cada 12 horas, Amlodipina 5mg diarios',
            'indicaciones' => 'Tomar con alimentos, evitar sales, realizar ejercicio regular',
            'fecha_inicio' => now()->subDays(5),
            'fecha_fin' => now()->addMonths(3),
            'estado' => 'En Proceso',
            'costo' => 250.00,
        ]);

        $tratamiento2 = Tratamiento::create([
            'paciente_id' => $paciente2->id,
            'consulta_id' => $consulta2->id,
            'doctor_id' => $personalDoctor1->id,
            'nombre_tratamiento' => 'Control de Diabetes',
            'descripcion' => 'Régimen de insulina y dieta controlada',
            'medicamentos' => 'Metformina 500mg 3 veces al día, Insulina NPH 20 unidades',
            'indicaciones' => 'Inyectarse insulina antes de dormir, monitorear glucosa diariamente',
            'fecha_inicio' => now()->subDays(30),
            'fecha_fin' => null,
            'estado' => 'En Proceso',
            'costo' => 400.00,
        ]);

        $tratamiento3 = Tratamiento::create([
            'paciente_id' => $paciente5->id,
            'consulta_id' => null,
            'doctor_id' => $personalDoctor1->id,
            'nombre_tratamiento' => 'Control de Asma',
            'descripcion' => 'Manejo del asma con inhaladores',
            'medicamentos' => 'Salbutamol 2 inhalaciones cuando sea necesario, Beclometasona diaria',
            'indicaciones' => 'Usar inhalador antes de ejercicio, evitar alérgenos',
            'fecha_inicio' => now()->subDays(60),
            'fecha_fin' => null,
            'estado' => 'En Proceso',
            'costo' => 180.00,
        ]);

        // ==================== COMPRAS ====================
        
        $compra1 = Compra::create([
            'realizado_por' => 1, // Personal del admin
            'proveedor' => 'Farmacéutica Central S.A.',
            'descripcion' => 'Compra de medicamentos varios',
            'monto_total' => 2500.00,
            'fecha_compra' => now()->subDays(10),
            'estado' => 'Recibida',
            'observaciones' => 'Entrega completada sin problemas',
        ]);

        DetalleCompra::create([
            'compra_id' => $compra1->id,
            'producto' => 'Enalapril 10mg (100 tablets)',
            'cantidad' => 5,
            'precio_unitario' => 150.00,
            'subtotal' => 750.00,
        ]);

        DetalleCompra::create([
            'compra_id' => $compra1->id,
            'producto' => 'Metformina 500mg (120 tablets)',
            'cantidad' => 3,
            'precio_unitario' => 200.00,
            'subtotal' => 600.00,
        ]);

        DetalleCompra::create([
            'compra_id' => $compra1->id,
            'producto' => 'Insulina NPH (10 viales)',
            'cantidad' => 2,
            'precio_unitario' => 575.00,
            'subtotal' => 1150.00,
        ]);

        $compra2 = Compra::create([
            'realizado_por' => 1,
            'proveedor' => 'Médica Supply Inc.',
            'descripcion' => 'Compra de materiales médicos',
            'monto_total' => 1800.00,
            'fecha_compra' => now()->subDays(5),
            'estado' => 'Aprobada',
            'observaciones' => 'Aprobado para envío',
        ]);

        DetalleCompra::create([
            'compra_id' => $compra2->id,
            'producto' => 'Guantes de látex (1000 pares)',
            'cantidad' => 2,
            'precio_unitario' => 450.00,
            'subtotal' => 900.00,
        ]);

        DetalleCompra::create([
            'compra_id' => $compra2->id,
            'producto' => 'Mascarillas quirúrgicas (500 unidades)',
            'cantidad' => 1,
            'precio_unitario' => 250.00,
            'subtotal' => 250.00,
        ]);

        DetalleCompra::create([
            'compra_id' => $compra2->id,
            'producto' => 'Jeringas 10ml (100 unidades)',
            'cantidad' => 4,
            'precio_unitario' => 150.00,
            'subtotal' => 600.00,
        ]);

        $compra3 = Compra::create([
            'realizado_por' => 1,
            'proveedor' => 'Equipos Médicos Avanzados',
            'descripcion' => 'Compra de equipos de laboratorio',
            'monto_total' => 5000.00,
            'fecha_compra' => now(),
            'estado' => 'Pendiente',
            'observaciones' => 'En proceso de aprobación',
        ]);

        DetalleCompra::create([
            'compra_id' => $compra3->id,
            'producto' => 'Analizador de sangre automático',
            'cantidad' => 1,
            'precio_unitario' => 5000.00,
            'subtotal' => 5000.00,
        ]);

        // ==================== MENSAJES DE CONFIRMACIÓN ====================
        
        $this->command->info('═══════════════════════════════════════════════════════');
        $this->command->info('✓ DATOS DE PRUEBA CREADOS EXITOSAMENTE');
        $this->command->info('═══════════════════════════════════════════════════════');
        
        $this->command->line('');
        $this->command->info('📋 RESUMEN DE DATOS CREADOS:');
        $this->command->line('  • 3 Doctores y 1 Enfermero registrados');
        $this->command->line('  • 5 Pacientes con historiales completos');
        $this->command->line('  • 5 Consultas médicas');
        $this->command->line('  • 4 Exámenes laboratoriales');
        $this->command->line('  • 3 Tratamientos médicos');
        $this->command->line('  • 3 Órdenes de compra con detalles');
        
        $this->command->line('');
        $this->command->info('👤 USUARIOS DE PRUEBA:');
        $this->command->line('  Admin: admin@sistema.com / admin123');
        $this->command->line('  Doctor 1: doctor1@sistema.com / doctor123');
        $this->command->line('  Doctor 2: doctor2@sistema.com / doctor123');
        $this->command->line('  Doctor 3: doctor3@sistema.com / doctor123');
        $this->command->line('  Enfermero: enfermero1@sistema.com / enfermero123');
        
        $this->command->line('');
        $this->command->info('═══════════════════════════════════════════════════════');
    }
}
