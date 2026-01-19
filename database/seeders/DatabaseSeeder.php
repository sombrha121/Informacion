<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Personal;
use App\Models\Paciente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario administrador
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@sistema.com',
            'password' => Hash::make('admin123'),
        ]);

        // Crear personal administrativo
        Personal::create([
            'user_id' => $admin->id,
            'nombre' => 'Administrador',
            'apellido' => 'Sistema',
            'dni' => '00000000',
            'tipo' => 'Administrativo',
            'especialidad' => null,
            'telefono' => '999999999',
            'email' => 'admin@sistema.com',
            'fecha_contratacion' => now(),
            'estado' => 'Activo',
        ]);

        // Crear un doctor
        $doctor = User::create([
            'name' => 'Dr. Juan Pérez',
            'email' => 'doctor@sistema.com',
            'password' => Hash::make('doctor123'),
        ]);

        Personal::create([
            'user_id' => $doctor->id,
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'dni' => '12345678',
            'tipo' => 'Doctor',
            'especialidad' => 'Medicina General',
            'telefono' => '987654321',
            'email' => 'doctor@sistema.com',
            'fecha_contratacion' => now(),
            'estado' => 'Activo',
        ]);

        // Crear algunos pacientes de prueba
        Paciente::create([
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
            'enfermedades_cronicas' => null,
        ]);

        Paciente::create([
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

        Paciente::create([
            'nombre' => 'Ana',
            'apellido' => 'Martínez',
            'dni' => '56789012',
            'fecha_nacimiento' => '1995-12-10',
            'genero' => 'F',
            'telefono' => '934567890',
            'email' => 'ana@example.com',
            'direccion' => 'Jr. Las Flores 789',
            'grupo_sanguineo' => 'B+',
            'alergias' => null,
            'enfermedades_cronicas' => null,
        ]);

        $this->command->info('Datos de prueba creados exitosamente!');
        $this->command->info('Usuario Admin - Email: admin@sistema.com - Password: admin123');
        $this->command->info('Usuario Doctor - Email: doctor@sistema.com - Password: doctor123');
    }
}
