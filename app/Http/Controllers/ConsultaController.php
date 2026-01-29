<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\Personal;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    public function index()
    {
        $consultas = Consulta::with(['paciente', 'doctor'])->latest('fecha_hora')->paginate(15);
        return view('consultas.index', compact('consultas'));
    }

    public function create()
    {
        $pacientes = Paciente::all();
        $doctores = Personal::where('tipo', 'Doctor')->where('estado', 'Activo')->get();
        return view('consultas.create', compact('pacientes', 'doctores'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'doctor_id' => 'required|exists:personal,id',
            'fecha_hora' => 'required|date',
            'motivo' => 'required|string',
            'diagnostico' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'estado' => 'required|in:Pendiente,En Proceso,Concluida,Cancelada',
            'costo' => 'required|numeric|min:0',
        ]);

        Consulta::create($validated);

        return redirect()->route('consultas.index')->with('success', 'Consulta registrada exitosamente');
    }

    public function show(Consulta $consulta)
    {
        $consulta->load(['paciente', 'doctor', 'examenes', 'tratamientos']);
        return view('consultas.show', compact('consulta'));
    }

    public function edit(Consulta $consulta)
    {
        $pacientes = Paciente::all();
        $doctores = Personal::where('tipo', 'Doctor')->where('estado', 'Activo')->get();
        return view('consultas.edit', compact('consulta', 'pacientes', 'doctores'));
    }

    public function update(Request $request, Consulta $consulta)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'doctor_id' => 'required|exists:personal,id',
            'fecha_hora' => 'required|date',
            'motivo' => 'required|string',
            'diagnostico' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'estado' => 'required|in:Pendiente,En Proceso,Concluida,Cancelada',
            'costo' => 'required|numeric|min:0',
        ]);

        $consulta->update($validated);

        return redirect()->route('consultas.show', $consulta)->with('success', 'Consulta actualizada exitosamente');
    }

    public function destroy(Consulta $consulta)
    {
        $consulta->delete();
        return redirect()->route('consultas.index')->with('success', 'Consulta eliminada exitosamente');
    }

    public function concluir(Consulta $consulta)
    {
        $consulta->update(['estado' => 'Concluida']);
        return redirect()->route('consultas.show', $consulta)->with('success', 'Consulta concluida exitosamente');
    }
}
