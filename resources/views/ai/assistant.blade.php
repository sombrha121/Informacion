@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient bg-primary text-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-1">🤖 Asistente IA Médico Inteligente</h4>
                            <small>Solución local, privada y gratuita con Ollama</small>
                        </div>
                        <div class="text-end">
                            <div class="badge bg-success p-2 mb-2">
                                <span class="spinner-grow spinner-grow-sm me-2"></span>
                                En Línea
                            </div>
                            <div class="small">Modelo: Mistral Local</div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Panel de Chat -->
                        <div class="col-lg-8">
                            <div class="card border-light">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">💬 Conversación</h6>
                                </div>
                                <div class="card-body" style="height: 500px; overflow-y: auto; background: #f8f9fa;" id="chatContainer">
                                    <div class="alert alert-info mb-3">
                                        <h6>👋 ¡Bienvenido!</h6>
                                        <p class="mb-0">Soy tu asistente médico IA. Puedo ayudarte con:</p>
                                        <ul class="mt-2 mb-0">
                                            <li>Responder preguntas sobre salud general</li>
                                            <li>Analizar síntomas reportados</li>
                                            <li>Sugerir tratamientos basados en diagnósticos</li>
                                            <li>Búsqueda de información médica</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-footer bg-white">
                                    <form id="formConsulta" class="needs-validation">
                                        <div class="mb-2">
                                            <label for="tipoConsulta" class="form-label small fw-bold">Tipo de Consulta:</label>
                                            <select class="form-select form-select-sm" id="tipoConsulta">
                                                <optgroup label="Consultas Generales">
                                                    <option value="pregunta">❓ Pregunta General</option>
                                                    <option value="sintomas">🏥 Analizar Síntomas</option>
                                                    <option value="diagnostico">💊 Sugerir Tratamiento</option>
                                                </optgroup>
                                                <optgroup label="Consultas del Sistema">
                                                    <option value="pacientes">👥 Consultar Pacientes</option>
                                                    <option value="consultas">🩺 Consultar Consultas Médicas</option>
                                                    <option value="examenes">🔬 Consultar Exámenes</option>
                                                    <option value="tratamientos">💉 Consultar Tratamientos</option>
                                                    <option value="compras">📦 Consultar Compras</option>
                                                    <option value="personal">👨‍⚕️ Consultar Personal</option>
                                                </optgroup>
                                                <optgroup label="Reportes">
                                                    <option value="reporte">📊 Generar Reporte General</option>
                                                </optgroup>
                                            </select>
                                        </div>

                                        <div class="input-group">
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="mensajeInput" 
                                                   placeholder="Escribe tu pregunta o consulta..." 
                                                   autocomplete="off">
                                            <button class="btn btn-primary" type="button" id="enviarBtn" onclick="enviarMensaje()">
                                                <i class="bi bi-send"></i> Enviar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Panel de Información -->
                        <div class="col-lg-4">
                            <!-- Información del Sistema -->
                            <div class="card border-light mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">⚙️ Sistema</h6>
                                </div>
                                <div class="card-body small">
                                    <div class="mb-2">
                                        <strong>Modelo:</strong><br>
                                        <span class="badge bg-info">Mistral 7B</span>
                                    </div>
                                    <div class="mb-2">
                                        <strong>API:</strong><br>
                                        <span class="badge bg-secondary">Ollama Local</span>
                                    </div>
                                    <div class="mb-2">
                                        <strong>Privacidad:</strong><br>
                                        <span class="badge bg-success">100% Local ✓</span>
                                    </div>
                                    <div>
                                        <strong>Costo:</strong><br>
                                        <span class="badge bg-warning">Gratuito</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Tips de Uso -->
                            <div class="card border-light mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">💡 Tips de Uso</h6>
                                </div>
                                <div class="card-body small">
                                    <ul class="mb-0">
                                        <li>✓ Sé específico en tus consultas</li>
                                        <li>✓ El asistente detecta intenciones</li>
                                        <li>✓ Te redirige automáticamente</li>
                                        <li>✓ Usa para análisis y navegación</li>
                                        <li>✓ Prueba pedir "crear paciente"</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Ejemplos -->
                            <div class="card border-light">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">📝 Ejemplos con Redirección</h6>
                                </div>
                                <div class="card-body small">
                                    <div class="mb-2">
                                        <strong>👤 Paciente:</strong><br>
                                        <em>"Quiero crear una ficha de paciente"</em><br>
                                        <span class="text-success">→ Te lleva a /pacientes</span>
                                    </div>
                                    <div class="mb-2">
                                        <strong>🩺 Consulta:</strong><br>
                                        <em>"Necesito agendar una cita"</em><br>
                                        <span class="text-success">→ Te lleva a /consultas</span>
                                    </div>
                                    <div class="mb-2">
                                        <strong>🔬 Examen:</strong><br>
                                        <em>"Solicitar análisis de sangre"</em><br>
                                        <span class="text-success">→ Te lleva a /examenes</span>
                                    </div>
                                    <div>
                                        <strong>👨‍⚕️ Personal:</strong><br>
                                        <em>"¿Qué médicos hay disponibles?"</em><br>
                                        <span class="text-success">→ Te lleva a /personal</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advertencia Importante -->
            <div class="alert alert-warning mt-3" role="alert">
                <strong>⚠️ Aviso Legal:</strong> Este asistente IA es una herramienta informativa solamente. 
                No diagnostica, no trata, ni reemplaza el consejo médico profesional. 
                Ante cualquier síntoma grave, busque atención médica inmediata.
            </div>
        </div>
    </div>
</div>

<style>
    #chatContainer {
        scroll-behavior: smooth;
    }

    .mensaje-usuario {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        border-radius: 18px;
        padding: 12px 16px;
        margin: 10px 0 10px auto;
        max-width: 85%;
        word-wrap: break-word;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        animation: slideIn 0.3s ease-in;
    }

    .mensaje-ia {
        background: #e9ecef;
        color: #333;
        border-radius: 18px;
        padding: 12px 16px;
        margin: 10px 0 10px 0;
        max-width: 85%;
        word-wrap: break-word;
        border-left: 4px solid #007bff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        animation: slideIn 0.3s ease-in;
    }

    .mensaje-hora {
        font-size: 0.75rem;
        opacity: 0.7;
        margin-top: 5px;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .spinner-grow-sm {
        width: 0.9rem;
        height: 0.9rem;
    }

    #enviarBtn:disabled {
        cursor: not-allowed;
    }
</style>

<script>
    function enviarMensaje() {
        const mensaje = document.getElementById('mensajeInput').value.trim();
        const tipo = document.getElementById('tipoConsulta').value;

        if (!mensaje) {
            alert('Por favor escribe un mensaje');
            return;
        }

        // Mostrar mensaje del usuario
        const container = document.getElementById('chatContainer');
        const divUsuario = document.createElement('div');
        divUsuario.className = 'mensaje-usuario';
        divUsuario.innerHTML = `
            ${escapeHtml(mensaje)}
            <div class="mensaje-hora">${new Date().toLocaleTimeString()}</div>
        `;
        container.appendChild(divUsuario);

        // Desabilitar botón
        const btn = document.getElementById('enviarBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Analizando...';

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
                    ${escapeHtml(data.respuesta).replace(/\n/g, '<br>')}
                    <div class="mensaje-hora">${new Date().toLocaleTimeString()}</div>
                `;
                container.appendChild(divIA);
                
                // Si hay redirección, mostrar botón y redirigir automáticamente
                if (data.redirigir && data.url) {
                    const divRedireccion = document.createElement('div');
                    divRedireccion.className = 'alert alert-success mt-3';
                    divRedireccion.innerHTML = `
                        <strong>🔄 Redirigiendo...</strong><br>
                        <a href="${data.url}" class="btn btn-success mt-2">
                            <i class="bi bi-arrow-right-circle"></i> Ir a ${data.modulo.charAt(0).toUpperCase() + data.modulo.slice(1)}
                        </a>
                    `;
                    container.appendChild(divRedireccion);
                    
                    // Redirigir automáticamente después de 3 segundos
                    setTimeout(() => {
                        window.location.href = data.url;
                    }, 3000);
                }
            } else {
                mostrarError(data.error || 'Error desconocido');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarError('Error de conexión. ¿Está Ollama ejecutándose? (ollama serve)');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-send"></i> Enviar';
            document.getElementById('mensajeInput').value = '';
            container.scrollTop = container.scrollHeight;
        });
    }

    function mostrarError(mensaje) {
        const container = document.getElementById('chatContainer');
        const divError = document.createElement('div');
        divError.className = 'alert alert-danger mb-0';
        divError.innerHTML = `<strong>⚠️ Error:</strong> ${escapeHtml(mensaje)}`;
        container.appendChild(divError);
        container.scrollTop = container.scrollHeight;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Permitir enviar con Enter
    document.getElementById('mensajeInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            enviarMensaje();
        }
    });

    // Auto-scroll al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('chatContainer');
        container.scrollTop = container.scrollHeight;
    });
</script>
@endsection
