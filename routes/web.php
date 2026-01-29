<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\ExamenController;
use App\Http\Controllers\TratamientoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ApiController;

// Rutas de autenticación
Route::get('/', [AuthController::class, 'showLoginForm'])->name('home');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    
    // Pacientes
    Route::resource('pacientes', PacienteController::class);
    
    // Consultas
    Route::resource('consultas', ConsultaController::class);
    Route::post('consultas/{consulta}/concluir', [ConsultaController::class, 'concluir'])->name('consultas.concluir');
    
    // Exámenes
    Route::resource('examenes', ExamenController::class);
    Route::post('examenes/{examen}/concluir', [ExamenController::class, 'concluir'])->name('examenes.concluir');
    
    // Tratamientos
    Route::resource('tratamientos', TratamientoController::class);
    Route::post('tratamientos/{tratamiento}/aceptar', [TratamientoController::class, 'aceptar'])->name('tratamientos.aceptar');
    Route::post('tratamientos/{tratamiento}/completar', [TratamientoController::class, 'completar'])->name('tratamientos.completar');
    
    // Compras
    Route::resource('compras', CompraController::class);
        // Compras
        Route::get('compras/{compra}/comprobante', [CompraController::class, 'comprobante'])->name('compras.comprobante');
    
    // Personal
    Route::resource('personal', PersonalController::class);
    
    // Reportes
    Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('reportes/pacientes', [ReporteController::class, 'pacientes'])->name('reportes.pacientes');
    Route::get('reportes/consultas', [ReporteController::class, 'consultas'])->name('reportes.consultas');
    Route::get('reportes/financiero', [ReporteController::class, 'financiero'])->name('reportes.financiero');
    
    // Historial del paciente
    Route::get('historial/{paciente}', [PacienteController::class, 'show'])->name('historial.show');
});

// Rutas API (sin autenticación por ahora, agregar si se necesita)
Route::middleware('auth')->group(function () {
    Route::get('/api/pacientes/search', [ApiController::class, 'searchPacientes'])->name('api.pacientes.search');
    Route::get('/api/charts/data', [ApiController::class, 'getChartData'])->name('api.charts.data');
});
