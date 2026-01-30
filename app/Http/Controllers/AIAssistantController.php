<?php

namespace App\Http\Controllers;

use App\Services\AIService;
use Illuminate\Http\Request;

class AIAssistantController extends Controller
{
    protected $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Mostrar interfaz del asistente
     */
    public function index()
    {
        return view('ai.assistant');
    }

    /**
     * Procesar consulta de IA
     */
    public function consultar(Request $request)
    {
        $request->validate([
            'mensaje' => 'required|string|max:1000',
            'tipo' => 'required|in:pregunta,sintomas,diagnostico,pacientes,consultas,examenes,tratamientos,compras,personal,reporte'
        ]);

        $mensaje = $request->input('mensaje');
        $tipo = $request->input('tipo');

        try {
            // Primero detectar si hay intención de redirección
            $intencion = $this->aiService->detectarIntencion($mensaje);
            
            if ($intencion) {
                return response()->json([
                    'exito' => true,
                    'redirigir' => true,
                    'url' => $intencion['url'],
                    'respuesta' => $intencion['mensaje'],
                    'modulo' => $intencion['modulo']
                ]);
            }
            
            // Si no hay redirección, procesar normalmente
            $respuesta = match($tipo) {
                'pregunta' => $this->aiService->responderPregunta($mensaje),
                'sintomas' => $this->aiService->analizarSintomas($mensaje),
                'diagnostico' => $this->aiService->sugerirTratamiento($mensaje),
                'pacientes' => $this->aiService->consultarPacientes($mensaje),
                'consultas' => $this->aiService->consultarConsultas($mensaje),
                'examenes' => $this->aiService->consultarExamenes($mensaje),
                'tratamientos' => $this->aiService->consultarTratamientos($mensaje),
                'compras' => $this->aiService->consultarCompras($mensaje),
                'personal' => $this->aiService->consultarPersonal($mensaje),
                'reporte' => $this->aiService->generarReporteGeneral(),
                default => 'Tipo de consulta no válido'
            };

            return response()->json([
                'exito' => true,
                'redirigir' => false,
                'respuesta' => $respuesta,
                'tipo' => $tipo
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'exito' => false,
                'error' => 'Error al procesar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Buscar información de paciente
     */
    public function buscar(Request $request)
    {
        $request->validate([
            'busqueda' => 'required|string|max:500'
        ]);

        try {
            $resultado = $this->aiService->buscarPaciente($request->input('busqueda'));

            return response()->json($resultado);
        } catch (\Exception $e) {
            return response()->json([
                'exito' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generar informe de IA
     */
    public function generarInforme(Request $request)
    {
        $request->validate([
            'datos' => 'required|string'
        ]);

        try {
            $informe = $this->aiService->generarInformeIA($request->input('datos'));

            return response()->json([
                'exito' => true,
                'informe' => $informe
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'exito' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
