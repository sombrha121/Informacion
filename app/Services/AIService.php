<?php

namespace App\Services;

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
     * Busca información de pacientes con IA
     */
    public function buscarPaciente(string $consulta): array
    {
        $prompt = "Eres un asistente médico. El usuario busca: {$consulta}. 
                   Proporciona una respuesta clara y profesional en formato JSON con estructura: 
                   {\"tipo\": \"búsqueda_paciente\", \"resultado\": \"...\"}";
        
        $respuesta = $this->generate($prompt);
        
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
