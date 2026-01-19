<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PersonalController extends Controller
{
    public function index()
    {
        $personal = Personal::with('user')->latest()->paginate(15);
        return view('personal.index', compact('personal'));
    }

    public function create()
    {
        return view('personal.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|unique:personal,dni',
            'tipo' => 'required|in:Doctor,Enfermero,Administrativo,Laboratorio',
            'especialidad' => 'nullable|string',
            'telefono' => 'nullable|string',
            'email' => 'required|email|unique:personal,email',
            'password' => 'required|string|min:8',
            'fecha_contratacion' => 'required|date',
            'estado' => 'required|in:Activo,Inactivo',
        ]);

        $user = User::create([
            'name' => $validated['nombre'] . ' ' . $validated['apellido'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Personal::create([
            'user_id' => $user->id,
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'dni' => $validated['dni'],
            'tipo' => $validated['tipo'],
            'especialidad' => $validated['especialidad'],
            'telefono' => $validated['telefono'],
            'email' => $validated['email'],
            'fecha_contratacion' => $validated['fecha_contratacion'],
            'estado' => $validated['estado'],
        ]);

        return redirect()->route('personal.index')->with('success', 'Personal registrado exitosamente');
    }

    public function show(Personal $personal)
    {
        $personal->load(['consultas', 'examenesSolicitados', 'tratamientos', 'compras']);
        return view('personal.show', compact('personal'));
    }

    public function edit(Personal $personal)
    {
        return view('personal.edit', compact('personal'));
    }

    public function update(Request $request, Personal $personal)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|unique:personal,dni,' . $personal->id,
            'tipo' => 'required|in:Doctor,Enfermero,Administrativo,Laboratorio',
            'especialidad' => 'nullable|string',
            'telefono' => 'nullable|string',
            'email' => 'required|email|unique:personal,email,' . $personal->id,
            'password' => 'nullable|string|min:8',
            'fecha_contratacion' => 'required|date',
            'estado' => 'required|in:Activo,Inactivo',
        ]);

        $personal->update($validated);

        $userData = [
            'name' => $validated['nombre'] . ' ' . $validated['apellido'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $personal->user->update($userData);

        return redirect()->route('personal.show', $personal)->with('success', 'Personal actualizado exitosamente');
    }

    public function destroy(Personal $personal)
    {
        $personal->user->delete();
        $personal->delete();
        return redirect()->route('personal.index')->with('success', 'Personal eliminado exitosamente');
    }
}
