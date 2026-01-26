# 🚀 GUÍA DE INICIO RÁPIDO

## Paso 1: Crear la Base de Datos

### Opción A: Desde HeidiSQL (Laragon)
1. Abrir HeidiSQL desde Laragon
2. Click derecho en la conexión
3. Seleccionar "Create new" → "Database"
4. Nombre: `sistema_medico`
5. Charset: `utf8mb4_unicode_ci`

### Opción B: Ejecutar script SQL
1. Abrir HeidiSQL
2. Abrir el archivo `crear_bd.sql`
3. Ejecutar (F9)

## Paso 2: Instalar el Sistema

### Opción Automática (Recomendada)
Ejecutar desde PowerShell en la carpeta del proyecto:
```powershell
.\instalar.ps1
```

### Opción Manual
```powershell
# 1. Generar clave de aplicación
php artisan key:generate

# 2. Ejecutar migraciones
php artisan migrate

# 3. Cargar datos de prueba
php artisan db:seed
```

## Paso 3: Iniciar el Servidor

### Opción A: Laravel Artisan
```powershell
php artisan serve
```
Acceder a: http://localhost:8000

### Opción B: Laragon (Automático)
Acceder a: http://prototipo.test

## 👤 Iniciar Sesión

### Administrador
- **Email**: admin@sistema.com
- **Password**: admin123

### Doctor
- **Email**: doctor@sistema.com
- **Password**: doctor123

## ✅ Sistema Listo!

Ya puedes usar todas las funcionalidades:
- ✓ Gestión de Pacientes
- ✓ Consultas Médicas
- ✓ Exámenes
- ✓ Tratamientos
- ✓ Compras
- ✓ Personal
- ✓ Reportes

---

## 🆘 Problemas Comunes

### "Base de datos no encontrada"
→ Crear la base de datos `sistema_medico` en MySQL

### "APP_KEY no configurada"
→ Ejecutar: `php artisan key:generate`

### "Class not found"
→ Ejecutar: `composer install`

### "Permission denied en storage"
→ Verificar permisos de la carpeta `storage`
