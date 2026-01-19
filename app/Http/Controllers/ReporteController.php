<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Examen;
use App\Models\Tratamiento;
use App\Models\Compra;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index()
    {
        $totalPacientes = Paciente::count();
        $consultasHoy = Consulta::whereDate('fecha_hora', today())->count();
        $examenesPendientes = Examen::where('estado', 'Solicitado')->count();
        $tratamientosActivos = Tratamiento::where('estado', 'En Proceso')->count();

        $consultasPorMes = Consulta::select(
            DB::raw('MONTH(fecha_hora) as mes'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('fecha_hora', date('Y'))
        ->groupBy('mes')
        ->get();

        $ingresosPorMes = Consulta::select(
            DB::raw('MONTH(fecha_hora) as mes'),
            DB::raw('SUM(costo) as total')
        )
        ->whereYear('fecha_hora', date('Y'))
        ->where('estado', 'Concluida')
        ->groupBy('mes')
        ->get();

        return view('reportes.index', compact(
            'totalPacientes',
            'consultasHoy',
            'examenesPendientes',
            'tratamientosActivos',
            'consultasPorMes',
            'ingresosPorMes'
        ));
    }

    public function pacientes()
    {
        $pacientes = Paciente::withCount(['consultas', 'examenes', 'tratamientos'])->get();
        return view('reportes.pacientes', compact('pacientes'));
    }

    public function consultas(Request $request)
    {
        $query = Consulta::with(['paciente', 'doctor']);

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha_hora', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha_hora', '<=', $request->fecha_fin);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $consultas = $query->get();

        return view('reportes.consultas', compact('consultas'));
    }

    public function financiero(Request $request)
    {
        $año = $request->input('año', date('Y'));
        $mes = $request->input('mes', null);

        // Consultas
        $queryConsultas = Consulta::whereYear('fecha_hora', $año)->where('estado', 'Concluida');
        if ($mes) $queryConsultas->whereMonth('fecha_hora', $mes);
        $ingresoConsultas = $queryConsultas->sum('costo');
        $consultasCompletadas = $queryConsultas->count();

        // Exámenes
        $queryExamenes = Examen::whereYear('fecha_solicitud', $año)->where('estado', 'Concluido');
        if ($mes) $queryExamenes->whereMonth('fecha_solicitud', $mes);
        $ingresoExamenes = $queryExamenes->sum('costo');
        $examenesCompletados = $queryExamenes->count();

        // Tratamientos
        $queryTratamientos = Tratamiento::whereYear('fecha_inicio', $año)->where('estado', 'Completado');
        if ($mes) $queryTratamientos->whereMonth('fecha_inicio', $mes);
        $ingresoTratamientos = $queryTratamientos->sum('costo');
        $tratamientosCompletados = $queryTratamientos->count();

        // Compras
        $queryCompras = Compra::whereYear('fecha_compra', $año)->whereIn('estado', ['Aprobada', 'Recibida']);
        if ($mes) $queryCompras->whereMonth('fecha_compra', $mes);
        $gastoCompras = $queryCompras->sum('monto_total');
        $comprasCompletadas = $queryCompras->count();

        // Totales
        $totalIngresos = $ingresoConsultas + $ingresoExamenes + $ingresoTratamientos;
        $totalGastos = $gastoCompras;
        $margenGanancia = $totalGastos > 0 ? round((($totalIngresos - $totalGastos) / $totalIngresos) * 100, 2) : 100;

        return view('reportes.financiero', compact(
            'año', 'mes', 'totalIngresos', 'totalGastos', 'margenGanancia',
            'ingresoConsultas', 'ingresoExamenes', 'ingresoTratamientos',
            'consultasCompletadas', 'examenesCompletados', 'tratamientosCompletados',
            'gastoCompras', 'comprasCompletadas'
        ));
    }
}
