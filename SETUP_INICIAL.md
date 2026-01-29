# 📋 Guía de Configuración Inicial del Proyecto

## 🚀 OPCIÓN RECOMENDADA: Usar Terminal de Laragon

**La forma MÁS FÁCIL es usar la terminal integrada de Laragon.**

### Pasos rápidos:

1. **Abre Laragon**
2. **Haz clic en el botón "Terminal"** (esquina inferior izquierda del panel de Laragon)
3. **Se abrirá una terminal con TODO ya configurado**
4. **Sigue los comandos abajo SIN necesidad de configurar PATH**

---

## **OPCIÓN 1: Usando Terminal de Laragon (RECOMENDADO)**

### Paso 1: Crear .env
```bash
copy .env.example .env
```

### Paso 2: Instalar Composer
```bash
composer install
```

### Paso 3: Generar clave
```bash
php artisan key:generate
```

### Paso 4: Crear base de datos en HeidiSQL

1. Abre HeidiSQL desde Laragon
2. Ejecuta:
```sql
CREATE DATABASE IF NOT EXISTS sistema_medico 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;
```

### Paso 5: Ejecutar migraciones
```bash
php artisan migrate --force
```

### Paso 6: Cargar datos de prueba
```bash
php artisan db:seed --force
```

### Paso 7: Instalar NPM
```bash
npm install
```

### Paso 8: Compilar assets
```bash
npm run build
```

### Paso 9: Iniciar servidor
```bash
php artisan serve
```

**¡LISTO! Tu aplicación está en http://127.0.0.1:8000**

---

## OPCIÓN 2: Pasos para Configurar el Proyecto desde PowerShell Manual

Si prefieres hacerlo desde PowerShell normal (SIN terminal de Laragon):

### Pasos para Configurar el Proyecto Laravel desde Cero

Si descargaste el proyecto de GitHub, sigue estos pasos:

---

## **PASO 1 (Manual): Crear archivo .env**

```powershell
Copy-Item .env.example .env
```

**Esto copia la configuración de ejemplo y crea tu archivo .env personalizado.**

---

## **PASO 2 (Manual): Configurar el archivo .env**

Abre el archivo `.env` y cambia estas líneas:

### Cambio 1: Nombre de la aplicación
```env
# DE ESTO:
APP_NAME=Laravel

# A ESTO:
APP_NAME="Sistema Médico"
APP_URL=http://informacion.test
```

### Cambio 2: Configuración de Base de Datos
```env
# DE ESTO:
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

# A ESTO:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_medico
DB_USERNAME=root
DB_PASSWORD=
```

---

## **PASO 3 (Manual): Crear la Base de Datos en HeidiSQL**

1. **Abre HeidiSQL** (desde Laragon)
2. **Conéctate a MySQL** (usuario: root, sin contraseña)
3. **Ejecuta este SQL:**

```sql
CREATE DATABASE IF NOT EXISTS sistema_medico 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;
```

**O manualmente:**
- Clic derecho en la conexión → Create new → Database
- Nombre: `sistema_medico`
- Collation: `utf8mb4_unicode_ci`

---

## **PASO 4 (Manual): Instalar Dependencias de Composer**

```powershell
# Configurar PATH y ejecutar composer
$env:Path = "c:\laragon\bin\php\php-8.3.28-Win32-vs16-x64;c:\laragon\bin\composer;" + $env:Path
composer install
```

**Esto instala todas las dependencias de PHP en la carpeta `vendor/`**

---

## **PASO 5 (Manual): Generar Clave de la Aplicación**

```powershell
$env:Path = "c:\laragon\bin\php\php-8.3.28-Win32-vs16-x64;" + $env:Path
php artisan key:generate
```

**Genera la `APP_KEY` necesaria para Laravel**

---

## **PASO 6 (Manual): Ejecutar Migraciones**

```powershell
$env:Path = "c:\laragon\bin\php\php-8.3.28-Win32-vs16-x64;" + $env:Path
php artisan migrate --force
```

**Crea todas las tablas en la base de datos:**
- users
- pacientes
- personal
- consultas
- examenes
- tratamientos
- compras
- detalle_compras
- Y más...

---

## **PASO 7 (Manual): Cargar Datos de Prueba (Seeders)**

```powershell
$env:Path = "c:\laragon\bin\php\php-8.3.28-Win32-vs16-x64;" + $env:Path
php artisan db:seed --force
```

**Carga datos de ejemplo para probar la aplicación**

---

## **PASO 8 (Manual): Instalar Dependencias de NPM**

```powershell
cmd /c "npm install"
```

**Instala las dependencias de JavaScript (Bootstrap, Vite, etc.)**

---

## **PASO 9 (Manual): Compilar Assets (CSS y JS)**

```powershell
cmd /c "npm run build"
```

**Compila los archivos CSS y JavaScript para producción**

---

## **PASO 10 (Manual): Asegúrate que MySQL esté corriendo**

1. Abre **Laragon**
2. Haz clic en **"Start All"** o **"Iniciar Todo"**
3. Verifica que veas:
   - ✅ Apache: Running
   - ✅ MySQL: Running

---

## **PASO 11 (Manual): Iniciar el Servidor**

```powershell
$env:Path = "c:\laragon\bin\php\php-8.3.28-Win32-vs16-x64;" + $env:Path
php artisan serve
```

**El servidor estará disponible en:**
- http://127.0.0.1:8000
- O desde Laragon: http://informacion.test

---

## **Credenciales de Acceso**

### Administrador:
- **Email:** admin@sistema.com
- **Password:** admin123

### Doctor:
- **Email:** doctor@sistema.com
- **Password:** doctor123

---

## **Resumen Rápido - Terminal de Laragon (RECOMENDADO) ⭐**

Si usas la terminal integrada de Laragon, los comandos son más simples:

```bash
copy .env.example .env
composer install
php artisan key:generate
# Crear base de datos en HeidiSQL aquí
php artisan migrate --force
php artisan db:seed --force
npm install
npm run build
php artisan serve
```

---

## **Resumen Rápido - PowerShell Manual**

Si prefieres usar PowerShell sin la terminal de Laragon:

```powershell
# 1. Copiar .env
Copy-Item .env.example .env

# 2. Configurar PATH (ejecutar en cada terminal nueva)
$env:Path = "c:\laragon\bin\php\php-8.3.28-Win32-vs16-x64;c:\laragon\bin\composer;" + $env:Path

# 3. Composer
composer install

# 4. Generar clave
php artisan key:generate

# 5. Migraciones
php artisan migrate --force

# 6. Seeders
php artisan db:seed --force

# 7. NPM
cmd /c "npm install"

# 8. Build
cmd /c "npm run build"

# 9. Servidor
php artisan serve
```

---

## **Notas Importantes**

⚠️ **Si tienes problemas:**

1. **"php no se reconoce"** → Usa la Terminal de Laragon (botón en el panel de Laragon) ⭐
2. **"No se puede conectar a MySQL"** → Abre Laragon y haz clic en "Start All"
3. **"Archivo .env no existe"** → Ejecuta: `copy .env.example .env` (Laragon) o `Copy-Item .env.example .env` (PowerShell)
4. **"Tablas no existen"** → Ejecuta: `php artisan migrate --force`
5. **Si todo falla, usa la Terminal de Laragon** - Es lo más fácil ⭐⭐⭐

---

## **Después de configurar todo:**

- ✅ Accede a http://127.0.0.1:8000
- ✅ Inicia sesión con admin@sistema.com / admin123
- ✅ Usa la aplicación normalmente

---

## **Para subir cambios a GitHub:**

```powershell
git add .
git commit -m "Describe tu cambio aquí"
git push origin main
```

---

**¡Listo! Tu proyecto está completamente configurado y listo para usar.** 🎉

**💡 TIP: La Terminal de Laragon es lo más fácil - ¡Úsala!** ⭐

