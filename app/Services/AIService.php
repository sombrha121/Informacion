<?php

namespace App\Services;

use App\Models\Paciente;
use App\Models\Consulta;
use App\Models\Examen;
use App\Models\Tratamiento;
use App\Models\Compra;
use App\Models\Personal;

class AIService
{
    private $ollamaUrl = 'http://127.0.0.1:11434/api/generate';
    private $model = 'mistral'; // o 'neural-chat'

    /**
     * Genera respuesta de IA
     */
    public function generate(string $prompt): string
    {
        try {
            $client = new \GuzzleHttp\Client();
            
            $response = $client->post($this->ollamaUrl, [
                'json' => [
                    'model' => $this->model,
                    'prompt' => $prompt,
                    'stream' => false,
                    'temperature' => 0.7,
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            
            return $data['response'] ?? 'No se pudo generar respuesta';
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    /**
     * Consulta datos de pacientes con IA
     */
    public function consultarPacientes(string $consulta): string
    {
        $totalPacientes = Paciente::count();
        $pacientesRecientes = Paciente::orderBy('created_at', 'desc')->take(5)->get();
        
        $listaPacientes = $pacientesRecientes->map(function($p) {
            return "- {$p->nombre} {$p->apellido} (DNI: {$p->dni}, Edad: {$p->edad} años, Tipo sangre: {$p->tipo_sangre})";
        })->implode("\n");

        $prompt = "Eres un asistente médico. El usuario pregunta: {$consulta}
        
        Datos del sistema:
        - Total de pacientes registrados: {$totalPacientes}
        - Últimos 5 pacientes registrados:
        {$listaPacientes}
        
        Proporciona una respuesta útil y profesional basada en estos datos.";
        
        return $this->generate($prompt);
    }

    /**
     * Consulta datos de consultas médicas
     */
    public function consultarConsultas(string $consulta): string
    {
        $totalConsultas = Consulta::count();
        $consultasPendientes = Consulta::where('estado', 'Programada')->count();
        $consultasHoy = Consulta::whereDate('fecha_consulta', today())->count();
        
        $prompt = "Eres un asistente médico. El usuario pregunta: {$consulta}
        
        Estadísticas del sistema:
        - Total de consultas: {$totalConsultas}
        - Consultas programadas pendientes: {$consultasPendientes}
        - Consultas para hoy: {$consultasHoy}
        
        Proporciona un análisis profesional de estos datos.";
        
        return $this->generate($prompt);
    }

    /**
     * Consulta datos de exámenes
     */
    public function consultarExamenes(string $consulta): string
    {
        $totalExamenes = Examen::count();
        $examenesPendientes = Examen::where('estado', 'Pendiente')->count();
        $tiposExamenes = Examen::select('tipo_examen')->distinct()->pluck('tipo_examen')->take(10)->implode(', ');
        
        $prompt = "Eres un asistente médico. El usuario pregunta: {$consulta}
        
        Información de exámenes:
        - Total de exámenes registrados: {$totalExamenes}
        - Exámenes pendientes: {$examenesPendientes}
        - Tipos de exámenes disponibles: {$tiposExamenes}
        
        Proporciona información útil basada en estos datos.";
        
        return $this->generate($prompt);
    }

    /**
     * Consulta datos de tratamientos
     */
    public function consultarTratamientos(string $consulta): string
    {
        $totalTratamientos = Tratamiento::count();
        $tratamientosActivos = Tratamiento::where('estado', 'En Proceso')->count();
        $costoTotal = Tratamiento::sum('costo');
        
        $prompt = "Eres un asistente médico. El usuario pregunta: {$consulta}
        
        Datos de tratamientos:
        - Total de tratamientos: {$totalTratamientos}
        - Tratamientos activos: {$tratamientosActivos}
        - Costo total acumulado: S/ {$costoTotal}
        
        Proporciona un análisis profesional.";
        
        return $this->generate($prompt);
    }

    /**
     * Consulta datos de compras
     */
    public function consultarCompras(string $consulta): string
    {
        $totalCompras = Compra::count();
        $comprasPendientes = Compra::where('estado', 'Pendiente')->count();
        $totalGastado = Compra::sum('total');
        
        $prompt = "Eres un asistente financiero médico. El usuario pregunta: {$consulta}
        
        Información de compras:
        - Total de compras registradas: {$totalCompras}
        - Compras pendientes de aprobación: {$comprasPendientes}
        - Total gastado: S/ {$totalGastado}
        
        Proporciona análisis financiero basado en estos datos.";
        
        return $this->generate($prompt);
    }

    /**
     * Consulta datos del personal
     */
    public function consultarPersonal(string $consulta): string
    {
        $totalPersonal = Personal::count();
        $doctores = Personal::where('tipo', 'Doctor')->count();
        $enfermeros = Personal::where('tipo', 'Enfermero')->count();
        $especialidades = Personal::where('tipo', 'Doctor')->distinct()->pluck('especialidad')->filter()->take(10)->implode(', ');
        
        $prompt = "Eres un asistente de recursos humanos médicos. El usuario pregunta: {$consulta}
        
        Datos del personal:
        - Total de personal: {$totalPersonal}
        - Doctores: {$doctores}
        - Enfermeros: {$enfermeros}
        - Especialidades disponibles: {$especialidades}
        
        Proporciona información útil sobre el personal.";
        
        return $this->generate($prompt);
    }

    /**
     * Genera reporte general del sistema
     */
    public function generarReporteGeneral(): string
    {
        $pacientes = Paciente::count();
        $consultas = Consulta::count();
        $examenes = Examen::count();
        $tratamientos = Tratamiento::count();
        $personal = Personal::count();
        $ingresos = Consulta::sum('costo') + Examen::sum('costo') + Tratamiento::sum('costo');
        $gastos = Compra::sum('total');
        
        $prompt = "Genera un reporte ejecutivo profesional del sistema médico con estos datos:
        
        ESTADÍSTICAS GENERALES:
        - Pacientes registrados: {$pacientes}
        - Consultas realizadas: {$consultas}
        - Exámenes solicitados: {$examenes}
        - Tratamientos prescritos: {$tratamientos}
        - Personal activo: {$personal}
        
        FINANCIERO:
        - Ingresos totales: S/ {$ingresos}
        - Gastos totales: S/ {$gastos}
        - Balance: S/ " . ($ingresos - $gastos) . "
        
        Proporciona:
        1. Resumen ejecutivo
        2. Análisis de tendencias
        3. Recomendaciones
        4. Puntos críticos a considerar";
        
        return $this->generate($prompt);
    }

    /**
     * Busca información de pacientes con IA
     */
    public function buscarPaciente(string $consulta): array
    {
        $respuesta = $this->consultarPacientes($consulta);
        
        return [
            'consulta' => $consulta,
            'respuesta' => $respuesta,
            'timestamp' => now()
        ];
    }

    /**
     * Analiza síntomas del paciente
     */
    public function analizarSintomas(string $sintomas): string
    {
        $prompt = "Eres un asistente médico profesional. El paciente reporta estos síntomas: {$sintomas}
                   Proporciona un análisis estructurado:
                   1. Análisis preliminar de síntomas
                   2. Posibles exámenes recomendados
                   3. Recordatorio importante: Esto no es un diagnóstico, debe consultar con un médico
                   
                   Sé profesional, cuidadoso y responsable.";
        
        return $this->generate($prompt);
    }

    /**
     * Genera recomendación de tratamiento
     */
    public function sugerirTratamiento(string $diagnostico): string
    {
        $prompt = "Eres un asistente médico. Basado en este diagnóstico: {$diagnostico}
                   Sugiere de forma estructurada:
                   1. Posibles medicamentos comunes (siendo profesional)
                   2. Recomendaciones de estilo de vida
                   3. Frecuencia de seguimiento recomendado
                   
                   IMPORTANTE: Aclarar que esto es una sugerencia informativa, 
                   el médico debe tomar la decisión final del tratamiento.";
        
        return $this->generate($prompt);
    }

    /**
     * Detecta intención de redirección
     */
    public function detectarIntencion(string $mensaje): ?array
    {
        $mensaje = strtolower($mensaje);
        
        // Palabras clave por módulo
        $patrones = [
            'pacientes' => ['paciente', 'registrar paciente', 'crear paciente', 'nuevo paciente', 'ficha', 'dni', 'alergias'],
            'consultas' => ['consulta', 'cita', 'doctor', 'agendar', 'programar consulta', 'reservar', 'diagnóstico'],
            'examenes' => ['examen', 'análisis', 'laboratorio', 'rayos x', 'ecografía', 'sangre', 'orina', 'resultado'],
            'tratamientos' => ['tratamiento', 'medicamento', 'receta', 'medicina', 'prescripción', 'dosis', 'terapia'],
            'compras' => ['compra', 'comprar', 'adquirir', 'pedido', 'proveedor', 'stock', 'inventario'],
            'personal' => ['personal', 'médico', 'enfermero', 'staff', 'empleado', 'especialista', 'quien', 'disponible'],
            'reportes' => ['reporte', 'estadística', 'informe', 'gráfico', 'análisis', 'dashboard', 'resumen']
        ];
        
        foreach ($patrones as $modulo => $palabras) {
            foreach ($palabras as $palabra) {
                if (strpos($mensaje, $palabra) !== false) {
                    return [
                        'modulo' => $modulo,
                        'url' => url($modulo),
                        'mensaje' => $this->generarMensajeRedireccion($modulo, $mensaje)
                    ];
                }
            }
        }
        
        return null;
    }
    
    /**
     * Genera mensaje de redirección personalizado
     */
    private function generarMensajeRedireccion(string $modulo, string $mensaje): string
    {
        $mensajes = [
            'pacientes' => "📋 Entiendo que quieres trabajar con pacientes. Te estoy redirigiendo al módulo de **Gestión de Pacientes** donde podrás:\n- Crear nuevas fichas de pacientes\n- Ver historial completo\n- Actualizar información médica",
            
            'consultas' => "🩺 Veo que necesitas gestionar consultas médicas. Te redirijo al módulo de **Consultas** donde podrás:\n- Programar nuevas citas\n- Ver consultas programadas\n- Registrar diagnósticos",
            
            'examenes' => "🔬 Entiendo que necesitas trabajar con exámenes. Te llevo al módulo de **Exámenes de Laboratorio** donde podrás:\n- Solicitar nuevos exámenes\n- Ver resultados pendientes\n- Actualizar resultados",
            
            'tratamientos' => "💊 Veo que quieres gestionar tratamientos. Te redirijo al módulo de **Tratamientos** donde podrás:\n- Prescribir nuevos tratamientos\n- Ver tratamientos activos\n- Actualizar medicamentos",
            
            'compras' => "📦 Entiendo que necesitas gestionar compras. Te llevo al módulo de **Compras e Inventario** donde podrás:\n- Registrar nuevas compras\n- Gestionar proveedores\n- Controlar stock",
            
            'personal' => "👨‍⚕️ Veo que buscas información del personal. Te redirijo al módulo de **Personal Médico** donde podrás:\n- Ver todo el personal disponible\n- Consultar especialidades\n- Gestionar doctores y enfermeros",
            
            'reportes' => "📊 Entiendo que necesitas ver reportes. Te llevo al módulo de **Reportes y Estadísticas** donde encontrarás:\n- Reportes de pacientes\n- Análisis de consultas\n- Estadísticas financieras"
        ];
        
        return $mensajes[$modulo] ?? "Te estoy redirigiendo al módulo correspondiente...";
    }

    /**
     * Responde preguntas generales
     */
    public function responderPregunta(string $pregunta): string
    {
        $prompt = "Eres un asistente médico útil, profesional y responsable. 
                   Pregunta del usuario: {$pregunta}
                   
                   Proporciona una respuesta clara, concisa y útil.
                   Si es una pregunta que requiere consulta médica profesional, acláral.";
        
        return $this->generate($prompt);
    }

    /**
     * Genera informe de paciente
     */
    public function generarInformeIA(string $datosCliente): string
    {
        $prompt = "Eres un asistente médico. Basado en estos datos de paciente:
                   {$datosCliente}
                   
                   Genera un informe estructurado con:
                   1. Resumen de la información
                   2. Puntos importantes a considerar
                   3. Recomendaciones generales
                   4. Alertas de salud si aplica";
        
        return $this->generate($prompt);
    }
}
