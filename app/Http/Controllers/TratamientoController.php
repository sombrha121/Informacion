<?php

namespace App\Http\Controllers;

use App\Models\Tratamiento;
use App\Models\Paciente;
use App\Models\Consulta;
use App\Models\Personal;
use Illuminate\Http\Request;

class TratamientoController extends Controller
{
    public function index()
    {
        $tratamientos = Tratamiento::with(['paciente', 'doctor'])->latest('fecha_inicio')->paginate(15);
        return view('tratamientos.index', compact('tratamientos'));
    }

    public function create()
    {
        $pacientes = Paciente::all();
        $consultas = Consulta::all();
        $doctores = Personal::where('tipo', 'Doctor')->where('estado', 'Activo')->get();
        return view('tratamientos.create', compact('pacientes', 'consultas', 'doctores'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'consulta_id' => 'nullable|exists:consultas,id',
            'doctor_id' => 'required|exists:personal,id',
            'nombre_tratamiento' => 'required|string',
            'descripcion' => 'required|string',
            'medicamentos' => 'nullable|string',
            'indicaciones' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date',
            'estado' => 'required|in:Pendiente,En Proceso,Completado,Cancelado',
            'costo' => 'required|numeric|min:0',
        ]);

        Tratamiento::create($validated);

        return redirect()->route('tratamientos.index')->with('success', 'Tratamiento registrado exitosamente');
    }

    public function show(Tratamiento $tratamiento)
    {
        $tratamiento->load(['paciente', 'consulta', 'doctor']);
        return view('tratamientos.show', compact('tratamiento'));
    }

    public function edit(Tratamiento $tratamiento)
    {
        $pacientes = Paciente::all();
        $consultas = Consulta::all();
        $doctores = Personal::where('tipo', 'Doctor')->where('estado', 'Activo')->get();
        return view('tratamientos.edit', compact('tratamiento', 'pacientes', 'consultas', 'doctores'));
    }

    public function update(Request $request, Tratamiento $tratamiento)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'consulta_id' => 'nullable|exists:consultas,id',
            'doctor_id' => 'required|exists:personal,id',
            'nombre_tratamiento' => 'required|string',
            'descripcion' => 'required|string',
            'medicamentos' => 'nullable|string',
            'indicaciones' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date',
            'estado' => 'required|in:Pendiente,En Proceso,Completado,Cancelado',
            'costo' => 'required|numeric|min:0',
        ]);

        $tratamiento->update($validated);

        return redirect()->route('tratamientos.show', $tratamiento)->with('success', 'Tratamiento actualizado exitosamente');
    }

    public function destroy(Tratamiento $tratamiento)
    {
        $tratamiento->delete();
        return redirect()->route('tratamientos.index')->with('success', 'Tratamiento eliminado exitosamente');
    }

    public function aceptar(Tratamiento $tratamiento)
    {
        $tratamiento->update(['estado' => 'En Proceso']);
        return redirect()->route('tratamientos.show', $tratamiento)->with('success', 'Tratamiento aceptado');
    }

    public function completar(Tratamiento $tratamiento)
    {
        $tratamiento->update([
            'estado' => 'Completado',
            'fecha_fin' => now(),
        ]);
        return redirect()->route('tratamientos.show', $tratamiento)->with('success', 'Tratamiento completado');
    }
}
