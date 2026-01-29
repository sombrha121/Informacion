<?php

namespace App\Http\Controllers;

use App\Models\Examen;
use App\Models\Paciente;
use App\Models\Consulta;
use App\Models\Personal;
use Illuminate\Http\Request;

class ExamenController extends Controller
{
    public function index()
    {
        $examenes = Examen::with(['paciente', 'solicitante'])->latest('fecha_solicitud')->paginate(15);
        return view('examenes.index', compact('examenes'));
    }

    public function create()
    {
        $pacientes = Paciente::all();
        $consultas = Consulta::all();
        $personal = Personal::where('estado', 'Activo')->get();
        return view('examenes.create', compact('pacientes', 'consultas', 'personal'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'consulta_id' => 'nullable|exists:consultas,id',
            'solicitado_por' => 'required|exists:personal,id',
            'tipo_examen' => 'required|string',
            'descripcion' => 'nullable|string',
            'fecha_solicitud' => 'required|date',
            'fecha_realizacion' => 'nullable|date',
            'resultados' => 'nullable|string',
            'estado' => 'required|in:Solicitado,En Proceso,Concluido,Cancelado',
            'costo' => 'required|numeric|min:0',
        ]);

        Examen::create($validated);

        return redirect()->route('examenes.index')->with('success', 'Examen registrado exitosamente');
    }

    public function show(Examen $examen)
    {
        $examen->load(['paciente', 'consulta', 'solicitante']);
        return view('examenes.show', compact('examen'));
    }

    public function edit(Examen $examen)
    {
        $pacientes = Paciente::all();
        $consultas = Consulta::all();
        $personal = Personal::where('estado', 'Activo')->get();
        return view('examenes.edit', compact('examen', 'pacientes', 'consultas', 'personal'));
    }

    public function update(Request $request, Examen $examen)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'consulta_id' => 'nullable|exists:consultas,id',
            'solicitado_por' => 'required|exists:personal,id',
            'tipo_examen' => 'required|string',
            'descripcion' => 'nullable|string',
            'fecha_solicitud' => 'required|date',
            'fecha_realizacion' => 'nullable|date',
            'resultados' => 'nullable|string',
            'estado' => 'required|in:Solicitado,En Proceso,Concluido,Cancelado',
            'costo' => 'required|numeric|min:0',
        ]);

        $examen->update($validated);

        return redirect()->route('examenes.show', $examen)->with('success', 'Examen actualizado exitosamente');
    }

    public function destroy(Examen $examen)
    {
        $examen->delete();
        return redirect()->route('examenes.index')->with('success', 'Examen eliminado exitosamente');
    }

    public function concluir(Request $request, Examen $examen)
    {
        $examen->update([
            'estado' => 'Concluido',
            'fecha_realizacion' => now(),
            'resultados' => $request->resultados,
        ]);

        return redirect()->route('examenes.show', $examen)->with('success', 'Examen concluido exitosamente');
    }
}
