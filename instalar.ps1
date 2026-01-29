# Script de Instalación - Sistema Médico Laravel
# Ejecutar desde PowerShell en c:\laragon\www\Prototipo

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  SISTEMA MÉDICO - INSTALACIÓN" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Configurar PATH para PHP
$env:Path = "c:\laragon\bin\php\php-8.3.28-Win32-vs16-x64;" + $env:Path

Write-Host "1. Generando clave de aplicación..." -ForegroundColor Yellow
php artisan key:generate
if ($LASTEXITCODE -eq 0) {
    Write-Host "   ✓ Clave generada exitosamente" -ForegroundColor Green
} else {
    Write-Host "   ✗ Error al generar la clave" -ForegroundColor Red
    exit
}

Write-Host ""
Write-Host "2. Ejecutando migraciones..." -ForegroundColor Yellow
php artisan migrate --force
if ($LASTEXITCODE -eq 0) {
    Write-Host "   ✓ Migraciones completadas" -ForegroundColor Green
} else {
    Write-Host "   ✗ Error en las migraciones" -ForegroundColor Red
    Write-Host "   Asegúrate de que:" -ForegroundColor Yellow
    Write-Host "   - MySQL esté corriendo en Laragon" -ForegroundColor Yellow
    Write-Host "   - La base de datos 'sistema_medico' exista" -ForegroundColor Yellow
    exit
}

Write-Host ""
Write-Host "3. Cargando datos de prueba..." -ForegroundColor Yellow
php artisan db:seed --force
if ($LASTEXITCODE -eq 0) {
    Write-Host "   ✓ Datos de prueba cargados" -ForegroundColor Green
} else {
    Write-Host "   ✗ Error al cargar datos" -ForegroundColor Red
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "  INSTALACIÓN COMPLETADA" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""
Write-Host "Credenciales de acceso:" -ForegroundColor Cyan
Write-Host ""
Write-Host "ADMINISTRADOR:" -ForegroundColor Yellow
Write-Host "  Email:    admin@sistema.com"
Write-Host "  Password: admin123"
Write-Host ""
Write-Host "DOCTOR:" -ForegroundColor Yellow
Write-Host "  Email:    doctor@sistema.com"
Write-Host "  Password: doctor123"
Write-Host ""
Write-Host "Para iniciar el servidor:" -ForegroundColor Cyan
Write-Host "  php artisan serve"
Write-Host ""
Write-Host "O accede desde Laragon:" -ForegroundColor Cyan
Write-Host "  http://prototipo.test"
Write-Host ""
