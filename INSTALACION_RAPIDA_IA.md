# ⚡ INSTALACIÓN RÁPIDA: IA ASISTENTE PARA TU PROYECTO

## 📋 CHECKLIST RÁPIDO

### 1️⃣ INSTALAR OLLAMA (5 minutos)
- [ ] Descargar desde https://ollama.ai
- [ ] Ejecutar instalador (siguiente, siguiente, siguiente)
- [ ] Verificar: `ollama --version` en PowerShell

### 2️⃣ DESCARGAR MODELO IA (5 minutos)
```powershell
ollama pull mistral
```

Espera a que termine (50-100MB descarga)

### 3️⃣ INICIAR OLLAMA
```powershell
ollama serve
```

Déjalo ejecutando. Verás:
```
listening on 127.0.0.1:11434
```

### 4️⃣ INSTALAR GUZZLE EN LARAVEL
En otra ventana PowerShell, en tu proyecto:
```powershell
cd c:\laragon\www\Informacion
composer require guzzlehttp/guzzle
```

### 5️⃣ COPIAR ARCHIVOS A TU PROYECTO

Los archivos están listos en:

**Backend:**
```
app/Services/AIService.php
app/Http/Controllers/AIAssistantController.php
```

**Vista:**
```
resources/views/ai/assistant.blade.php
```

**Rutas:** Ya agregadas en `routes/web.php`

### 6️⃣ ACCEDER A LA INTERFAZ

1. Abre tu navegador
2. Ve a: `http://tu-proyecto.test/ia-asistente`
3. ¡Comienza a usar!

---

## 🎯 CASOS DE USO

### Usar como Administrador
```
1. Ir a /ia-asistente
2. Escribir una pregunta médica
3. Elegir tipo: Pregunta, Síntomas o Tratamiento
4. Enviar y recibir análisis inteligente
```

### Integrar en otros módulos
Puedes usar el servicio en cualquier controlador:

```php
use App\Services\AIService;

public function miMetodo()
{
    $ai = new AIService();
    $respuesta = $ai->responderPregunta("¿Qué es la gripe?");
    return $respuesta;
}
```

---

## ⚙️ CONFIGURACIÓN AVANZADA

### Cambiar modelo
En `app/Services/AIService.php`:

```php
private $model = 'mistral'; // Cambiar a 'neural-chat' u otro

// Descargar otros modelos:
// ollama pull neural-chat
// ollama pull dolphin-mixtral
// ollama pull llama2
```

### Ajustar temperatura (creatividad)
```php
'temperature' => 0.7, // 0=respuestas exactas, 1=más creativo
```

---

## 🔧 SOLUCIÓN DE PROBLEMAS

### ❌ Error: "Connection refused"
**Solución:** Ollama no está ejecutándose
```powershell
ollama serve
```

### ❌ Error: "Model not found"
**Solución:** Descargar el modelo
```powershell
ollama pull mistral
```

### ❌ Respuestas muy lentas
**Solución:** Cambiar a modelo más pequeño
```powershell
ollama pull neural-chat
```

Luego en AIService.php: `private $model = 'neural-chat';`

### ❌ "Permission Denied"
**Solución:** Ejecutar PowerShell como administrador

---

## 📊 ESTADÍSTICAS DEL SISTEMA

| Aspecto | Detalle |
|---------|---------|
| **Costo** | Gratuito |
| **Privacidad** | 100% Local |
| **Velocidad** | ~2-5 segundos por respuesta |
| **Modelo** | Mistral 7B |
| **RAM Requerida** | 8GB+ recomendado |
| **Almacenamiento** | ~4GB para el modelo |

---

## 🚀 SIGUIENTES PASOS

1. ✅ Instala Ollama
2. ✅ Copia los archivos
3. ✅ Ejecuta `ollama serve`
4. ✅ Instala Guzzle
5. ✅ Accede a `/ia-asistente`
6. ✅ ¡Prueba el asistente!

---

## 📚 RECURSOS

- Documentación Ollama: https://ollama.ai
- Modelos disponibles: https://ollama.ai/library
- Documentación completa: Ver `GUIA_OLLAMA_IA_LOCAL.md`

---

**¡Tu IA Asistente está lista! 🎉**

Si tienes problemas, revisa la guía completa: `GUIA_OLLAMA_IA_LOCAL.md`
