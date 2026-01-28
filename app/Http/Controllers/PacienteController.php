<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::latest()->paginate(10);
        return view('pacientes.index', compact('pacientes'));
    }

    public function create()
    {
        return view('pacientes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/u'],
            'apellido' => ['required', 'string', 'max:255', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/u'],
            'dni' => ['required', 'digits_between:6,15', 'unique:pacientes,dni'],
            'fecha_nacimiento' => 'required|date',
            'meses_vida' => 'nullable|integer|min:0|max:11',
            'genero' => 'required|in:M,F,Otro',
            'telefono' => ['nullable', 'digits_between:6,15'],
            'email' => 'nullable|email',
            'direccion' => 'nullable|string',
            'grupo_sanguineo' => 'nullable|string',
            'alergias' => 'nullable|string',
            'enfermedades_cronicas' => 'nullable|string',
        ], [
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios.',
            'dni.digits_between' => 'El DNI debe contener solo números.',
            'telefono.digits_between' => 'El teléfono debe contener solo números.',
        ]);

        Paciente::create($validated);

        return redirect()->route('pacientes.index')->with('success', 'Paciente registrado exitosamente');
    }

    public function show(Paciente $paciente)
    {
        $paciente->load(['consultas', 'examenes', 'tratamientos']);
        return view('pacientes.show', compact('paciente'));
    }

    public function edit(Paciente $paciente)
    {
        return view('pacientes.edit', compact('paciente'));
    }

    public function update(Request $request, Paciente $paciente)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|unique:pacientes,dni,' . $paciente->id,
            'fecha_nacimiento' => 'required|date',
            'meses_vida' => 'nullable|integer|min:0|max:11',
            'genero' => 'required|in:M,F,Otro',
            'telefono' => 'nullable|string',
            'email' => 'nullable|email',
            'direccion' => 'nullable|string',
            'grupo_sanguineo' => 'nullable|string',
            'alergias' => 'nullable|string',
            'enfermedades_cronicas' => 'nullable|string',
        ]);

        $paciente->update($validated);

        return redirect()->route('pacientes.show', $paciente)->with('success', 'Paciente actualizado exitosamente');
    }

    public function destroy(Paciente $paciente)
    {
        $paciente->delete();
        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado exitosamente');
    }
}
