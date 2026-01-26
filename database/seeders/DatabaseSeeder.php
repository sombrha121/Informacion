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
        
        // Array con datos de 55 pacientes
        $pacientesData = [
            ['María', 'González', '45678901', '1990-05-15', 'F', '965432178', 'maria1@example.com', 'Av. Principal 123', 'O+', 'Penicilina', 'Hipertensión'],
            ['Carlos', 'Rodríguez', '78901234', '1985-08-20', 'M', '912345678', 'carlos1@example.com', 'Calle Los Olivos 456', 'A+', null, 'Diabetes tipo 2'],
            ['Ana', 'Martínez', '56789012', '1995-12-10', 'F', '934567890', 'ana1@example.com', 'Jr. Las Flores 789', 'B+', 'Aspirina', null],
            ['Pedro', 'López', '89012345', '2010-03-22', 'M', '956789012', 'pedro1@example.com', 'Av. Libertad 321', 'AB+', null, null],
            ['Sandra', 'Hernández', '67890123', '1988-11-07', 'F', '978901234', 'sandra1@example.com', 'Jr. Central 654', 'O-', 'Antibióticos', 'Asma'],
            ['Jorge', 'Fernández', '12345611', '1992-03-18', 'M', '965789012', 'jorge@example.com', 'Calle Mayor 101', 'A-', null, 'Colesterol alto'],
            ['Lucía', 'Torres', '98765411', '1997-07-22', 'F', '934123456', 'lucia@example.com', 'Av. Secundaria 202', 'B+', 'Ibuprofeno', null],
            ['David', 'García', '11223311', '1980-11-30', 'M', '987654301', 'david@example.com', 'Jr. Norte 303', 'O+', null, 'Hipertensión'],
            ['Isabel', 'Romero', '55667711', '2005-02-14', 'F', '912345601', 'isabel@example.com', 'Calle Sur 404', 'A+', 'Penicilina', null],
            ['Raúl', 'Morales', '99887711', '1987-09-05', 'M', '965432201', 'raul@example.com', 'Av. Este 505', 'B-', null, 'Asma'],
            ['Mariana', 'Soto', '22334411', '1993-04-12', 'F', '934567201', 'mariana@example.com', 'Jr. Oeste 606', 'AB+', null, 'Tiroidismo'],
            ['Esteban', 'Herrera', '66778911', '1989-06-08', 'M', '987123456', 'esteban@example.com', 'Calle Hermosa 707', 'O+', 'Cefalosporinas', 'Diabetes'],
            ['Vanessa', 'Chávez', '44556611', '2000-10-25', 'F', '965012345', 'vanessa@example.com', 'Av. Bella 808', 'A+', null, null],
            ['Gustavo', 'Reyes', '88990011', '1995-01-20', 'M', '912678901', 'gustavo@example.com', 'Jr. Alegre 909', 'B+', null, 'Colesterol'],
            ['Elena', 'Ruiz', '33445511', '1988-08-13', 'F', '934890123', 'elena@example.com', 'Calle Feliz 1010', 'O-', 'Ácido acetilsalicílico', 'Migraña'],
            ['Felipe', 'Domínguez', '77889911', '1991-05-09', 'M', '987345678', 'felipe@example.com', 'Av. Fresca 1111', 'A-', null, null],
            ['Catalina', 'Mendoza', '22110011', '1998-12-03', 'F', '965678901', 'catalina@example.com', 'Jr. Verde 1212', 'B+', null, 'Depresión'],
            ['Roberto', 'Bravo', '66334411', '1983-02-28', 'M', '912234567', 'roberto@example.com', 'Calle Azul 1313', 'AB+', 'Penicilina', 'Hipertensión'],
            ['Marta', 'Parra', '99223311', '2002-07-19', 'F', '934456789', 'marta@example.com', 'Av. Rosa 1414', 'O+', null, null],
            ['Julio', 'Vargas', '44778911', '1986-09-11', 'M', '987789012', 'julio@example.com', 'Jr. Naranja 1515', 'A+', null, 'Gota'],
            ['Sofía', 'Cruz', '11334411', '1999-03-07', 'F', '965345678', 'sofia@example.com', 'Calle Roja 1616', 'B-', 'Sulfonamidas', null],
            ['Andrés', 'Silva', '55776611', '1993-11-22', 'M', '912567890', 'andres@example.com', 'Av. Morada 1717', 'O+', null, 'Gastritis'],
            ['Patricia', 'Flores', '88112211', '1990-08-30', 'F', '934234567', 'patricia@example.com', 'Jr. Gris 1818', 'A+', null, 'Artrosis'],
            ['Víctor', 'Montoya', '22556611', '1984-04-16', 'M', '987456789', 'victor@example.com', 'Calle Negra 1919', 'B+', 'Penicilina', 'Presión alta'],
            ['Alejandra', 'Ramos', '66889911', '2001-01-25', 'F', '965123456', 'alejandra@example.com', 'Av. Blanca 2020', 'AB-', null, null],
            ['Fabio', 'Muñoz', '99445511', '1996-06-14', 'M', '912345098', 'fabio@example.com', 'Jr. Marrón 2121', 'O+', null, 'Baja visión'],
            ['Camila', 'Vega', '33667711', '1994-09-02', 'F', '934123098', 'camila@example.com', 'Calle Turquesa 2222', 'A-', 'Ibuprofeno', 'Ansiedad'],
            ['Maximiliano', 'Ortiz', '77005511', '1989-12-19', 'M', '987234567', 'max@example.com', 'Av. Púrpura 2323', 'B+', null, null],
            ['Daniela', 'Ramírez', '44223311', '2003-05-08', 'F', '965234567', 'daniela@example.com', 'Jr. Beige 2424', 'O+', null, 'Sobrepeso'],
            ['Nicolás', 'Fuentes', '88556611', '1988-10-21', 'M', '912123456', 'nicolas@example.com', 'Calle Marfil 2525', 'A+', 'Aspirina', 'Hipertensión'],
            ['Gabriela', 'Jiménez', '55334411', '2000-02-12', 'F', '934567098', 'gabriela@example.com', 'Av. Índigo 2626', 'B-', null, null],
            ['Leonardo', 'Gutiérrez', '99667711', '1992-07-29', 'M', '987678901', 'leonardo@example.com', 'Jr. Coral 2727', 'AB+', null, 'Estrés'],
            ['Florencia', 'Castro', '22445511', '1998-04-17', 'F', '965567890', 'florencia@example.com', 'Calle Olive 2828', 'O+', 'Penicilina', null],
            ['Sebastián', 'Navarro', '66223311', '1985-08-26', 'M', '912456789', 'sebastian@example.com', 'Av. Chocolate 2929', 'A+', null, 'Diabetes'],
            ['Rosario', 'Sánchez', '11556611', '2002-11-03', 'F', '934345678', 'rosario@example.com', 'Jr. Crema 3030', 'B+', null, null],
            ['Benjamin', 'Maldonado', '44889911', '1991-01-15', 'M', '987345098', 'benjamin@example.com', 'Calle Plata 3131', 'O-', 'Sulfonamidas', 'Tos crónica'],
            ['Victoria', 'Cordero', '77112211', '1997-09-06', 'F', '965678012', 'victoria@example.com', 'Av. Oro 3232', 'A-', null, null],
            ['Armando', 'Rosales', '88334411', '1986-03-22', 'M', '912789012', 'armando@example.com', 'Jr. Jade 3333', 'B+', 'Cefalosporinas', 'Rinitis'],
            ['Verónica', 'Iglesias', '33889911', '1999-05-14', 'F', '934678901', 'veronica@example.com', 'Calle Ámbar 3434', 'AB+', null, null],
            ['Cristian', 'Moreno', '55667711', '1993-10-31', 'M', '987012345', 'cristian@example.com', 'Av. Topacio 3535', 'O+', null, 'Insomnio'],
            ['Mónica', 'Ponce', '99112211', '2001-06-23', 'F', '965234098', 'monica@example.com', 'Jr. Ópalo 3636', 'A+', 'Ibuprofen', null],
            ['Rodrigo', 'Vásquez', '22667711', '1990-12-07', 'M', '912678012', 'rodrigo@example.com', 'Calle Rubí 3737', 'B-', null, 'Próstata'],
            ['Adriana', 'Reyes', '66445511', '1996-02-20', 'F', '934890012', 'adriana@example.com', 'Av. Diamante 3838', 'O+', 'Penicilina', null],
            ['Miguel', 'Peña', '77334411', '1988-07-11', 'M', '987567890', 'miguel@example.com', 'Jr. Zafiro 3939', 'A+', null, 'Psoriasis'],
            ['Esperanza', 'Carrasco', '11223311', '2004-04-09', 'F', '965345098', 'esperanza@example.com', 'Calle Berilo 4040', 'B+', null, null],
            ['Alfonso', 'González', '44556711', '1989-09-25', 'M', '912345678', 'alfonso@example.com', 'Av. Cuarzo 4141', 'AB-', 'Aspirina', 'Hipertensión'],
            ['Leonor', 'Medina', '88990011', '1997-01-18', 'F', '934567012', 'leonor@example.com', 'Jr. Sílex 4242', 'O+', null, null],
            ['Fernando', 'Herrera', '33445511', '1991-08-04', 'M', '987234098', 'fernando@example.com', 'Calle Mica 4343', 'A+', null, 'Gastritis'],
            ['Irene', 'Valencia', '55667811', '1999-03-27', 'F', '965678901', 'irene@example.com', 'Av. Feldespato 4444', 'B+', 'Penicilina', null],
            ['Guillermo', 'Salinas', '99887711', '1986-11-09', 'M', '912456012', 'guillermo@example.com', 'Jr. Basalto 4545', 'O-', null, 'Depresión'],
            ['Beatriz', 'Nuñez', '22334511', '2002-07-21', 'F', '934234098', 'beatriz@example.com', 'Calle Mármol 4646', 'A-', 'Sulfonamidas', null],
            ['Augusto', 'Fuerte', '45123678', '1991-02-14', 'M', '912567034', 'augusto@example.com', 'Av. Fuerte 4747', 'O+', null, null],
            ['Cecilia', 'Rojas', '78234901', '1994-06-28', 'F', '934789123', 'cecilia@example.com', 'Jr. Rojos 4848', 'A-', 'Penicilina', null],
            ['Damián', 'Santos', '56401234', '1987-09-10', 'M', '965890245', 'damian@example.com', 'Calle Santos 4949', 'B+', null, 'Gastritis'],
            ['Emilia', 'Vargas', '89512345', '2001-01-05', 'F', '912345067', 'emilia@example.com', 'Av. Vargas 5050', 'AB+', null, null],
            ['Franklin', 'Jiménez', '67623456', '1988-04-19', 'M', '934567089', 'franklin@example.com', 'Jr. Jiménez 5151', 'O-', 'Sulfonamidas', 'Diabetes'],
        ];

        $pacientes = [];
        foreach ($pacientesData as $i => $data) {
            $pacientes[] = Paciente::create([
                'nombre' => $data[0],
                'apellido' => $data[1],
                'dni' => $data[2],
                'fecha_nacimiento' => $data[3],
                'genero' => $data[4],
                'telefono' => $data[5],
                'email' => $data[6],
                'direccion' => $data[7],
                'grupo_sanguineo' => $data[8],
                'alergias' => $data[9],
                'enfermedades_cronicas' => $data[10],
            ]);
        }

        $paciente1 = $pacientes[0];
        $paciente2 = $pacientes[1];
        $paciente3 = $pacientes[2];
        $paciente4 = $pacientes[3];
        $paciente5 = $pacientes[4];

        // ==================== CONSULTAS ====================
        
        // Crear múltiples consultas para cada paciente
        $consultasData = [];
        
        for ($i = 0; $i < count($pacientes); $i++) {
            $paciente = $pacientes[$i];
            $doctorId = ($i % 3 == 0) ? $personalDoctor1->id : (($i % 3 == 1) ? $personalDoctor2->id : $personalDoctor3->id);
            
            // 2-3 consultas por paciente
            for ($j = 0; $j < rand(2, 3); $j++) {
                $consultasData[] = Consulta::create([
                    'paciente_id' => $paciente->id,
                    'doctor_id' => $doctorId,
                    'fecha_hora' => now()->subDays(rand(1, 60))->setTime(rand(8, 17), rand(0, 59)),
                    'motivo' => $this->getMotivosConsulta()[$i % count($this->getMotivosConsulta())],
                    'diagnostico' => rand(0, 1) ? $this->getDiagnosticos()[$i % count($this->getDiagnosticos())] : null,
                    'observaciones' => rand(0, 1) ? $this->getObservaciones()[$i % count($this->getObservaciones())] : null,
                    'estado' => rand(0, 3) > 1 ? 'Concluida' : (rand(0, 1) ? 'En Proceso' : 'Pendiente'),
                    'costo' => rand(100, 250),
                ]);
            }
        }

        $consulta1 = $consultasData[0];
        $consulta2 = $consultasData[1];
        $consulta3 = $consultasData[2];
        $consulta4 = $consultasData[3];
        $consulta5 = $consultasData[4];

        // ==================== EXÁMENES ====================
        
        // Crear exámenes para consultas concluidas
        $examenesCreados = 0;
        foreach ($consultasData as $consulta) {
            if ($consulta->estado === 'Concluida' && $examenesCreados < 80) {
                if (rand(0, 1)) { // 50% probabilidad de que tenga examen
                    Examen::create([
                        'paciente_id' => $consulta->paciente_id,
                        'consulta_id' => $consulta->id,
                        'solicitado_por' => $consulta->doctor_id,
                        'tipo_examen' => $this->getTiposExamen()[$examenesCreados % count($this->getTiposExamen())],
                        'descripcion' => $this->getDescripcionesExamen()[$examenesCreados % count($this->getDescripcionesExamen())],
                        'fecha_solicitud' => $consulta->fecha_hora,
                        'fecha_realizacion' => $consulta->fecha_hora->addDays(rand(1, 3)),
                        'resultados' => $this->getResultadosExamen()[$examenesCreados % count($this->getResultadosExamen())],
                        'estado' => 'Concluido',
                        'costo' => rand(50, 150),
                    ]);
                    $examenesCreados++;
                }
            }
        }

        $examen1 = Examen::where('paciente_id', $paciente1->id)->first() ?? Examen::create([
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

        $examen2 = Examen::where('paciente_id', $paciente2->id)->first() ?? Examen::create([
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

        $examen3 = Examen::where('paciente_id', $paciente3->id)->first() ?? Examen::create([
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

        $examen4 = Examen::where('paciente_id', $paciente4->id)->first() ?? Examen::create([
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
        
        $tratamientosCreados = 0;
        foreach ($pacientes as $paciente) {
            if ($tratamientosCreados < 50) {
                $numTratamientos = rand(1, 2);
                for ($t = 0; $t < $numTratamientos; $t++) {
                    Tratamiento::create([
                        'paciente_id' => $paciente->id,
                        'consulta_id' => $consultasData[rand(0, count($consultasData) - 1)]->id ?? null,
                        'doctor_id' => ($paciente->id % 3 == 0) ? $personalDoctor1->id : (($paciente->id % 3 == 1) ? $personalDoctor2->id : $personalDoctor3->id),
                        'nombre_tratamiento' => $this->getNombresTratamientos()[$tratamientosCreados % count($this->getNombresTratamientos())],
                        'descripcion' => $this->getDescripcionesTratamientos()[$tratamientosCreados % count($this->getDescripcionesTratamientos())],
                        'medicamentos' => $this->getMedicamentos()[$tratamientosCreados % count($this->getMedicamentos())],
                        'indicaciones' => $this->getIndicaciones()[$tratamientosCreados % count($this->getIndicaciones())],
                        'fecha_inicio' => now()->subDays(rand(5, 60)),
                        'fecha_fin' => rand(0, 1) ? now()->addDays(rand(30, 180)) : null,
                        'estado' => rand(0, 1) ? 'En Proceso' : 'Completado',
                        'costo' => rand(150, 500),
                    ]);
                    $tratamientosCreados++;
                }
            }
        }

        $tratamiento1 = Tratamiento::where('paciente_id', $paciente1->id)->first() ?? Tratamiento::create([
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

        $tratamiento2 = Tratamiento::where('paciente_id', $paciente2->id)->first() ?? Tratamiento::create([
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

        $tratamiento3 = Tratamiento::where('paciente_id', $paciente5->id)->first() ?? Tratamiento::create([
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
        
        $comprasData = [
            ['Farmacéutica Central S.A.', 'Compra de medicamentos varios', 2500.00, -10, 'Recibida'],
            ['Médica Supply Inc.', 'Compra de materiales médicos', 1800.00, -5, 'Aprobada'],
            ['Equipos Médicos Avanzados', 'Compra de equipos de laboratorio', 5000.00, 0, 'Pendiente'],
            ['Laboratorios Estériles', 'Compra de medicinas y vacunas', 3200.00, -15, 'Recibida'],
            ['Farmacia General', 'Surtido de medicamentos comunes', 1500.00, -8, 'Recibida'],
            ['Suministros Médicos Profesionales', 'Equipamiento hospitalario', 4500.00, -20, 'Aprobada'],
            ['Distribuidora Farmacéutica Nacional', 'Medicamentos especializados', 2800.00, -3, 'En Proceso'],
            ['Clínica Supply', 'Productos de higiene y desinfección', 950.00, -12, 'Recibida'],
            ['Proveedores de Medicamentos', 'Lote grande de antibióticos', 3500.00, -7, 'Aprobada'],
            ['Empresa Médica Global', 'Equipo de diagnóstico', 6000.00, 2, 'Pendiente'],
        ];
        
        $detalles = [
            ['Enalapril 10mg (100 tablets)', 5, 150.00],
            ['Metformina 500mg (120 tablets)', 3, 200.00],
            ['Insulina NPH (10 viales)', 2, 575.00],
            ['Guantes de látex (1000 pares)', 2, 450.00],
            ['Mascarillas quirúrgicas (500 unidades)', 1, 250.00],
            ['Jeringas 10ml (100 unidades)', 4, 150.00],
            ['Analizador de sangre automático', 1, 5000.00],
            ['Amoxicilina 500mg (100 caps)', 6, 120.00],
            ['Ibuprofeno 400mg (200 tablets)', 4, 80.00],
            ['Ampicilina (100 viales)', 3, 250.00],
            ['Suero fisiológico (500ml)', 10, 50.00],
            ['Alcohol al 70% (1 litro)', 8, 40.00],
            ['Algodón estéril (1kg)', 5, 60.00],
            ['Vendas elásticas (100 unidades)', 3, 75.00],
            ['Apósitos estériles (500 unidades)', 2, 100.00],
            ['Guantes de nitrilo (1000 pares)', 4, 200.00],
            ['Termómetro digital', 6, 45.00],
            ['Monitor de presión arterial', 2, 350.00],
            ['Glucómetro digital', 5, 200.00],
            ['Oxímetro de pulso', 3, 180.00],
        ];
        
        $comprasCreadas = 0;
        foreach ($comprasData as $compraData) {
            $compra = Compra::create([
                'realizado_por' => 1,
                'proveedor' => $compraData[0],
                'descripcion' => $compraData[1],
                'monto_total' => $compraData[2],
                'fecha_compra' => now()->addDays($compraData[3]),
                'estado' => $compraData[4],
                'observaciones' => rand(0, 1) ? 'Entrega completada sin problemas' : 'En proceso de entrega',
            ]);
            
            // Agregar 2-4 detalles por compra
            $numDetalles = rand(2, 4);
            $totalCompra = 0;
            for ($d = 0; $d < $numDetalles; $d++) {
                $detalle = $detalles[($comprasCreadas + $d) % count($detalles)];
                $subtotal = $detalle[1] * $detalle[2];
                $totalCompra += $subtotal;
                
                DetalleCompra::create([
                    'compra_id' => $compra->id,
                    'producto' => $detalle[0],
                    'cantidad' => $detalle[1],
                    'precio_unitario' => $detalle[2],
                    'subtotal' => $subtotal,
                ]);
            }
            
            // Actualizar monto total
            $compra->update(['monto_total' => $totalCompra]);
            $comprasCreadas++;
        }
        
        // Crear compras originales como ejemplo
        $compra1 = Compra::create([
            'realizado_por' => 1,
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
        $this->command->line('  • 55 Pacientes con historiales completos');
        $this->command->line('  • ' . count($consultasData) . ' Consultas médicas');
        $this->command->line('  • ' . Examen::count() . ' Exámenes laboratoriales');
        $this->command->line('  • ' . Tratamiento::count() . ' Tratamientos médicos');
        $this->command->line('  • 13 Órdenes de compra con detalles');
        $this->command->line('  • ' . DetalleCompra::count() . ' Detalles de compras');
        
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

    // Métodos auxiliares para obtener datos aleatorios
    private function getMotivosConsulta(): array
    {
        return [
            'Revisión de presión arterial',
            'Control de diabetes',
            'Chequeo cardiaco de rutina',
            'Revisión periódica infantil',
            'Control de asma',
            'Dolor de cabeza recurrente',
            'Problemas digestivos',
            'Revisión de infección respiratoria',
            'Control de colesterol',
            'Revisión de problemas de espalda',
            'Chequeo general de salud',
            'Seguimiento de tratamiento previo',
            'Evaluación de nuevos síntomas',
            'Control de medicación',
            'Revisión de alergias',
            'Evaluación de fatiga persistente',
            'Revisión de problemas del sueño',
            'Chequeo de vista',
        ];
    }

    private function getDiagnosticos(): array
    {
        return [
            'Hipertensión controlada',
            'Diabetes tipo 2 estable',
            'Sin anomalías cardíacas',
            'Niño sano',
            'Asma bajo control',
            'Cefalea tensional',
            'Gastritis leve',
            'Infección respiratoria resuelta',
            'Colesterol elevado',
            'Lumbalgia mecánica',
            'Paciente saludable',
            'Tratamiento efectivo',
            'Mejoría en síntomas',
            'Alergia estacional',
            'Insomnio transitorio',
            'Stress emocional',
        ];
    }

    private function getObservaciones(): array
    {
        return [
            'Continuar con medicación actual',
            'Mantener dieta y ejercicio',
            'Corazón sano, continuar con rutina',
            'Desarrollo normal',
            'Usar inhalador antes de ejercicio',
            'Realizar seguimiento en 2 semanas',
            'Evitar alimentos grasosos',
            'Aplicar tratamiento prescrito',
            'Realizar ejercicio regularmente',
            'Mantener hidratación adecuada',
            'Evitar estrés y fatigas',
            'Realizar exámenes de control',
            'Cambios de estilo de vida recomendados',
            'Seguimiento cada mes',
            'Reevaluar en 3 meses',
        ];
    }

    private function getTiposExamen(): array
    {
        return [
            'Análisis de sangre',
            'Hemoglobina A1c',
            'Electrocardiograma',
            'Radiografía de tórax',
            'Tomografía computarizada',
            'Resonancia magnética',
            'Prueba de función pulmonar',
            'Análisis de orina',
            'Perfil lipídico',
            'Función hepática',
            'Función renal',
            'Ultrasonido abdominal',
            'Endoscopia',
            'Colonoscopia',
            'Densitometría ósea',
        ];
    }

    private function getDescripcionesExamen(): array
    {
        return [
            'Perfil completo de sangre',
            'Control de diabetes',
            'ECG de rutina',
            'Control pediátrico',
            'Evaluación cardiaca completa',
            'Descartar infecciones',
            'Control de inflamación',
            'Evaluación de metabolismo',
            'Screening de cáncer',
            'Evaluación de órganos internos',
            'Análisis preventivo',
            'Seguimiento de enfermedad crónica',
            'Evaluación prequirúrgica',
            'Monitoreo de medicación',
        ];
    }

    private function getResultadosExamen(): array
    {
        return [
            'Glucosa: 95 mg/dl, Colesterol: 180 mg/dl',
            'HbA1c: 7.2%',
            'Ritmo normal, sin anomalías',
            'Normal, sin signos de patología',
            'Ligera elevación de enzimas',
            'Resultados dentro de rango normal',
            'Presión arterial controlada',
            'Función renal normal',
            'Análisis satisfactorio',
            'Sin hallazgos significativos',
            'Mejoría respecto a estudios previos',
            'Cambios mínimos detectados',
            'Requiere seguimiento',
            'Valores estables',
            'Inflamación disminuida',
        ];
    }

    private function getNombresTratamientos(): array
    {
        return [
            'Control de Hipertensión',
            'Control de Diabetes',
            'Control de Asma',
            'Manejo del Colesterol',
            'Tratamiento de Gastritis',
            'Control de Artrosis',
            'Manejo del Estrés',
            'Tratamiento de Alergias',
            'Rehabilitación Cardíaca',
            'Terapia de Dolor Crónico',
            'Prevención de Complicaciones',
            'Recuperación Postoperatoria',
            'Terapia Preventiva',
            'Manejo de Infecciones',
            'Control de Peso',
        ];
    }

    private function getDescripcionesTratamientos(): array
    {
        return [
            'Tratamiento farmacológico para controlar la presión arterial',
            'Régimen de insulina y dieta controlada',
            'Manejo del asma con inhaladores',
            'Terapia para reducir niveles de colesterol',
            'Protección gástrica y cambios dietéticos',
            'Fisioterapia y medicación',
            'Técnicas de relajación y apoyo psicológico',
            'Antihistamínicos y evitar alérgenos',
            'Ejercicio controlado y seguimiento médico',
            'Analgésicos y fisioterapia',
            'Seguimiento regular y pruebas diagnósticas',
            'Ejercicios de recuperación',
            'Medidas de prevención y seguimiento',
            'Antibióticos según corresponda',
            'Dieta balanceada y ejercicio',
        ];
    }

    private function getMedicamentos(): array
    {
        return [
            'Enalapril 10mg cada 12 horas, Amlodipina 5mg diarios',
            'Metformina 500mg 3 veces al día, Insulina NPH 20 unidades',
            'Salbutamol 2 inhalaciones cuando sea necesario, Beclometasona diaria',
            'Simvastatina 20mg diarios, Ezetimiba 10mg diarios',
            'Ranitidina 150mg 2 veces al día, Omeprazol 20mg al dormir',
            'Ibuprofeno 400mg cada 8 horas, Glucosamina 1500mg diarios',
            'Alprazolam 0.5mg al dormir, Sertralina 50mg matutino',
            'Cetirizina 10mg diarios, Loratadina si es necesario',
            'Atenolol 50mg diarios, Nitroglicerina sublingual si es necesario',
            'Paracetamol 500mg cada 6 horas, Tramadol 50mg si es necesario',
            'Aspirina 100mg diarios, Clopidogrel 75mg diarios',
            'Amoxicilina 500mg cada 8 horas por 7 días',
            'Ciprofloxacina 500mg cada 12 horas por 5 días',
            'Penicilina V 500mg cada 6 horas por 10 días',
            'Metformina 850mg 2 veces al día, Glibenclamida 5mg diarios',
        ];
    }

    private function getIndicaciones(): array
    {
        return [
            'Tomar con alimentos, evitar sales, realizar ejercicio regular',
            'Inyectarse insulina antes de dormir, monitorear glucosa diariamente',
            'Usar inhalador antes de ejercicio, evitar alérgenos',
            'Tomar con comidas, mantener dieta baja en grasas',
            'Tomar con alimentos para evitar irritación gástrica',
            'Aplicar en las articulaciones afectadas dos veces al día',
            'Tomar en la noche, evitar conducir, consultar si hay efectos secundarios',
            'Evitar alimentos que causen alergia, llevar antihistamínico siempre',
            'Ejercicio suave diario, evitar esfuerzos bruscos',
            'Aplicar calor local, realizar ejercicios de estiramiento',
            'Tomar regularmente, no automedicarse con otros fármacos',
            'Completar el ciclo de antibióticos, evitar bebidas alcohólicas',
            'No interrumpir el tratamiento, reportar efectos adversos',
            'Mantener vigilancia médica regular, ajustar dosis si es necesario',
            'Realizar controles periódicos de glucosa, seguir dieta prescrita',
        ];
    }
}
