<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Buscar pacientes para autocomplete
     */
    public function searchPacientes(Request $request)
    {
        $query = $request->input('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $pacientes = Paciente::where('estado', 'Activo')
            ->where(function ($q) use ($query) {
                $q->where('nombre', 'like', "%$query%")
                  ->orWhere('apellido', 'like', "%$query%")
                  ->orWhere('dni', 'like', "%$query%");
            })
            ->select('id', 'nombre', 'apellido', 'dni', 'fecha_nacimiento')
            ->limit(10)
            ->get()
            ->map(function ($paciente) {
                return [
                    'id' => $paciente->id,
                    'text' => "{$paciente->nombre} {$paciente->apellido} - {$paciente->dni}",
                    'nombre' => $paciente->nombre_completo,
                    'dni' => $paciente->dni,
                    'edad' => $paciente->edad,
                ];
            });

        return response()->json($pacientes);
    }

    /**
     * Obtener datos para gráficos de reportes
     */
    public function getChartData(Request $request)
    {
        $tipo = $request->input('tipo', 'consultas');
        $año = $request->input('año', date('Y'));

        $data = [];

        if ($tipo === 'consultas') {
            $data = $this->getConsultasData($año);
        } elseif ($tipo === 'ingresos') {
            $data = $this->getIngresosData($año);
        } elseif ($tipo === 'examenes') {
            $data = $this->getExamenesData($año);
        }

        return response()->json($data);
    }

    private function getConsultasData($año)
    {
        $consultas = \App\Models\Consulta::whereYear('fecha_hora', $año)
            ->selectRaw('MONTH(fecha_hora) as mes, COUNT(*) as total')
            ->groupByRaw('MONTH(fecha_hora)')
            ->get()
            ->keyBy('mes');

        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = $consultas->get($i)->total ?? 0;
        }

        return [
            'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            'data' => $data
        ];
    }

    private function getIngresosData($año)
    {
        $ingresos = \App\Models\Consulta::whereYear('fecha_hora', $año)
            ->where('estado', 'Concluida')
            ->selectRaw('MONTH(fecha_hora) as mes, SUM(costo) as total')
            ->groupByRaw('MONTH(fecha_hora)')
            ->get()
            ->keyBy('mes');

        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = $ingresos->get($i)->total ?? 0;
        }

        return [
            'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            'data' => $data
        ];
    }

    private function getExamenesData($año)
    {
        $estados = ['Solicitado', 'En Proceso', 'Concluido'];
        $data = [];

        foreach ($estados as $estado) {
            $data[] = \App\Models\Examen::whereYear('fecha_solicitud', $año)
                ->where('estado', $estado)
                ->count();
        }

        return [
            'labels' => $estados,
            'data' => $data
        ];
    }
}
