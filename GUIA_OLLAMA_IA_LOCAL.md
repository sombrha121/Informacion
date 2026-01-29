# 🤖 GUÍA: ASISTENTE IA LOCAL CON OLLAMA

## 📌 ¿QUÉ ES OLLAMA?

Ollama es una herramienta que permite ejecutar modelos de lenguaje (LLM) localmente en tu computadora **de forma completamente gratuita**, sin necesidad de conexión a internet ni pago de APIs.

### Ventajas
✅ Gratuito
✅ Funciona offline (sin internet)
✅ Privado (tus datos no se envían a servidores externos)
✅ Rápido
✅ Modelos de IA de alta calidad

---

## 🚀 INSTALACIÓN EN WINDOWS

### PASO 1: Descargar Ollama

1. Ve a https://ollama.ai
2. Descarga la versión para Windows
3. Ejecuta el instalador y sigue los pasos

### PASO 2: Verificar Instalación

Abre PowerShell y ejecuta:

```powershell
ollama --version
```

Deberías ver la versión de Ollama.

### PASO 3: Descargar un Modelo

```powershell
ollama pull mistral
```

O si prefieres un modelo más pequeño y rápido:

```powershell
ollama pull neural-chat
```

Opciones de modelos:
- `mistral` - Muy bueno, equilibrado (7B)
- `neural-chat` - Más pequeño, rápido (7B)
- `dolphin-mixtral` - Avanzado, requiere más recursos (34B)
- `llama2` - Clásico de Meta (7B)

### PASO 4: Iniciar Ollama en Segundo Plano

```powershell
ollama serve
```

Déjalo corriendo en una ventana de PowerShell. Verás:

```
time=2024-01-29 loading model ...
time=2024-01-29 listening on 127.0.0.1:11434
```

---

## 🔗 INTEGRACIÓN CON LARAVEL

### PASO 1: Crear Servicio IA

Crea el archivo: `app/Services/AIService.php`

```php
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
        $prompt = "Eres un asistente médico. El paciente reporta estos síntomas: {$sintomas}
                   Proporciona:
                   1. Análisis preliminar
                   2. Exámenes que podrían ser útiles
                   3. Recordatorio que debe ver a un médico
                   Sé profesional y cuidadoso.";
        
        return $this->generate($prompt);
    }

    /**
     * Genera recomendación de tratamiento
     */
    public function sugerirTratamiento(string $diagnostico): string
    {
        $prompt = "Eres un asistente médico. Basado en este diagnóstico: {$diagnostico}
                   Sugiere:
                   1. Posibles medicamentos comunes (con profesionalismo)
                   2. Recomendaciones de estilo de vida
                   3. Cuándo hacer seguimiento
                   Nota: Esto es una sugerencia, el médico debe tomar la decisión final.";
        
        return $this->generate($prompt);
    }

    /**
     * Responde preguntas generales
     */
    public function responderPregunta(string $pregunta): string
    {
        $prompt = "Eres un asistente médico útil y profesional. 
                   Pregunta: {$pregunta}
                   Proporciona una respuesta clara, concisa y útil.";
        
        return $this->generate($prompt);
    }
}
```

### PASO 2: Instalar Guzzle HTTP

En PowerShell en la carpeta del proyecto:

```powershell
composer require guzzlehttp/guzzle
```

### PASO 3: Crear Controlador

Crea: `app/Http/Controllers/AIAssistantController.php`

```php
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
            'tipo' => 'required|in:pregunta,sintomas,diagnostico'
        ]);

        $mensaje = $request->input('mensaje');
        $tipo = $request->input('tipo');

        $respuesta = match($tipo) {
            'pregunta' => $this->aiService->responderPregunta($mensaje),
            'sintomas' => $this->aiService->analizarSintomas($mensaje),
            'diagnostico' => $this->aiService->sugerirTratamiento($mensaje),
            default => 'Tipo de consulta no válido'
        };

        return response()->json([
            'exito' => true,
            'respuesta' => $respuesta,
            'tipo' => $tipo
        ]);
    }

    /**
     * Buscar información de paciente
     */
    public function buscar(Request $request)
    {
        $request->validate([
            'busqueda' => 'required|string|max:500'
        ]);

        $resultado = $this->aiService->buscarPaciente($request->input('busqueda'));

        return response()->json($resultado);
    }
}
```

### PASO 4: Crear Rutas

Abre `routes/web.php` y añade al final:

```php
// Rutas del Asistente IA
Route::middleware(['auth'])->group(function () {
    Route::get('/ia-asistente', [AIAssistantController::class, 'index'])->name('ia.index');
    Route::post('/ia-consultar', [AIAssistantController::class, 'consultar'])->name('ia.consultar');
    Route::post('/ia-buscar', [AIAssistantController::class, 'buscar'])->name('ia.buscar');
});
```

### PASO 5: Crear Vista

Crea la carpeta: `resources/views/ai/`

Crea el archivo: `resources/views/ai/assistant.blade.php`

```blade
@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-0">🤖 Asistente IA Médico</h4>
                            <small>Asistente inteligente para consultas médicas</small>
                        </div>
                        <div class="badge bg-success p-2">
                            <span class="spinner-border spinner-border-sm me-2"></span>
                            Modelo: Mistral Local
                        </div>
                    </div>
                </div>

                <div class="card-body" style="height: 500px; overflow-y: auto;" id="chatContainer">
                    <!-- Los mensajes aparecerán aquí -->
                    <div class="alert alert-info">
                        👋 ¡Hola! Soy tu asistente médico IA. Puedo ayudarte con:
                        <ul class="mt-2 mb-0">
                            <li>Responder preguntas sobre salud</li>
                            <li>Analizar síntomas</li>
                            <li>Sugerir tratamientos</li>
                            <li>Buscar información de pacientes</li>
                        </ul>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="mb-3">
                        <label for="tipoConsulta" class="form-label">Tipo de Consulta:</label>
                        <select class="form-select" id="tipoConsulta">
                            <option value="pregunta">Pregunta General</option>
                            <option value="sintomas">Analizar Síntomas</option>
                            <option value="diagnostico">Sugerir Tratamiento</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <input type="text" class="form-control" id="mensajeInput" 
                               placeholder="Escribe tu pregunta o consulta..." 
                               @keypress="if($event.key === 'Enter') enviarMensaje()">
                        <button class="btn btn-primary" id="enviarBtn" onclick="enviarMensaje()">
                            Enviar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Información de uso -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">💡 Tips</h6>
                        </div>
                        <div class="card-body small">
                            <ul>
                                <li>Sé específico en tus consultas</li>
                                <li>El asistente es informativo, no reemplaza médicos</li>
                                <li>Usa para búsquedas y análisis preliminares</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">⚙️ Información del Sistema</h6>
                        </div>
                        <div class="card-body small">
                            <p><strong>Modelo:</strong> Mistral (Local)</p>
                            <p><strong>API:</strong> Ollama</p>
                            <p><strong>Privacidad:</strong> 100% Local ✓</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #chatContainer {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
    }

    .mensaje-usuario {
        background: #007bff;
        color: white;
        border-radius: 12px;
        padding: 10px 15px;
        margin: 10px 0;
        max-width: 80%;
        margin-left: auto;
    }

    .mensaje-ia {
        background: #e9ecef;
        color: #333;
        border-radius: 12px;
        padding: 10px 15px;
        margin: 10px 0;
        max-width: 80%;
        border-left: 4px solid #007bff;
    }

    .mensaje-hora {
        font-size: 0.85rem;
        color: #999;
        margin-top: 5px;
    }
</style>

<script>
    function enviarMensaje() {
        const mensaje = document.getElementById('mensajeInput').value;
        const tipo = document.getElementById('tipoConsulta').value;

        if (!mensaje.trim()) {
            alert('Por favor escribe un mensaje');
            return;
        }

        // Mostrar mensaje del usuario
        const container = document.getElementById('chatContainer');
        const divUsuario = document.createElement('div');
        divUsuario.className = 'mensaje-usuario';
        divUsuario.innerHTML = `
            ${mensaje}
            <div class="mensaje-hora">${new Date().toLocaleTimeString()}</div>
        `;
        container.appendChild(divUsuario);

        // Desabilitar botón y mostrar cargando
        const btn = document.getElementById('enviarBtn');
        btn.disabled = true;
        btn.innerHTML = 'Analizando...';

        // Enviar al servidor
        fetch('{{ route("ia.consultar") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                mensaje: mensaje,
                tipo: tipo
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.exito) {
                const divIA = document.createElement('div');
                divIA.className = 'mensaje-ia';
                divIA.innerHTML = `
                    ${data.respuesta}
                    <div class="mensaje-hora">${new Date().toLocaleTimeString()}</div>
                `;
                container.appendChild(divIA);
            } else {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al conectar con Ollama. ¿Está Ollama ejecutándose?');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = 'Enviar';
            document.getElementById('mensajeInput').value = '';
            container.scrollTop = container.scrollHeight;
        });
    }

    // Permitir enviar con Enter
    document.getElementById('mensajeInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            enviarMensaje();
        }
    });
</script>
@endsection
```

---

## 📝 PASOS DE IMPLEMENTACIÓN

### 1. **Instala Ollama**
   - Descárgalo de https://ollama.ai
   - Instala normalmente

### 2. **Descarga un modelo**
   ```powershell
   ollama pull mistral
   ```

### 3. **Inicia Ollama**
   ```powershell
   ollama serve
   ```
   Déjalo corriendo de fondo.

### 4. **Implementa los archivos en tu proyecto**
   - Copia AIService.php en `app/Services/`
   - Copia AIAssistantController.php en `app/Http/Controllers/`
   - Crea la vista assistant.blade.php
   - Añade las rutas en web.php

### 5. **Instala Guzzle**
   ```powershell
   composer require guzzlehttp/guzzle
   ```

### 6. **Accede a la interfaz**
   Visita: `http://tuproyecto.test/ia-asistente`

---

## 🔧 RESOLUCIÓN DE PROBLEMAS

### ❌ "Error: Failed to connect to Ollama"
- Verifica que Ollama esté ejecutándose
- En PowerShell: `ollama serve`

### ❌ "Model not found"
- Descarga el modelo: `ollama pull mistral`

### ❌ Respuestas lentas
- Usa un modelo más pequeño: `neural-chat`
- O: `ollama pull mistral:7b`

### ❌ "Permission denied"
- Reinicia Ollama con admin
- O reinicia tu PC

---

## 🚀 MEJORAS FUTURAS

1. ✨ Guardar historial de conversaciones
2. ✨ Múltiples modelos disponibles
3. ✨ Análisis de documentos médicos
4. ✨ Integración con historiales de pacientes
5. ✨ Exportar conversaciones a PDF
6. ✨ Análisis de tendencias con IA

---

**¡Tu asistente IA está listo! 🎉**
