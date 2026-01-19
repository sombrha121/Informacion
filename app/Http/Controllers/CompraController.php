<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::with('realizadoPor')->latest('fecha_compra')->paginate(15);
        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        $personal = Personal::where('estado', 'Activo')->get();
        return view('compras.create', compact('personal'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'realizado_por' => 'required|exists:personal,id',
            'proveedor' => 'required|string',
            'descripcion' => 'required|string',
            'fecha_compra' => 'required|date',
            'estado' => 'required|in:Pendiente,Aprobada,Recibida,Cancelada',
            'observaciones' => 'nullable|string',
            'detalles' => 'required|array',
            'detalles.*.producto' => 'required|string',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            $monto_total = 0;
            
            foreach ($validated['detalles'] as $detalle) {
                $monto_total += $detalle['cantidad'] * $detalle['precio_unitario'];
            }

            $compra = Compra::create([
                'realizado_por' => $validated['realizado_por'],
                'proveedor' => $validated['proveedor'],
                'descripcion' => $validated['descripcion'],
                'monto_total' => $monto_total,
                'fecha_compra' => $validated['fecha_compra'],
                'estado' => $validated['estado'],
                'observaciones' => $validated['observaciones'] ?? null,
            ]);

            foreach ($validated['detalles'] as $detalle) {
                DetalleCompra::create([
                    'compra_id' => $compra->id,
                    'producto' => $detalle['producto'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'],
                    'subtotal' => $detalle['cantidad'] * $detalle['precio_unitario'],
                ]);
            }
        });

        return redirect()->route('compras.index')->with('success', 'Compra registrada exitosamente');
    }

    public function show(Compra $compra)
    {
        $compra->load(['realizadoPor', 'detalles']);
        return view('compras.show', compact('compra'));
    }

    public function edit(Compra $compra)
    {
        $compra->load('detalles');
        $personal = Personal::where('estado', 'Activo')->get();
        return view('compras.edit', compact('compra', 'personal'));
    }

    public function update(Request $request, Compra $compra)
    {
        $validated = $request->validate([
            'realizado_por' => 'required|exists:personal,id',
            'proveedor' => 'required|string',
            'descripcion' => 'required|string',
            'fecha_compra' => 'required|date',
            'estado' => 'required|in:Pendiente,Aprobada,Recibida,Cancelada',
            'observaciones' => 'nullable|string',
            'detalles' => 'required|array',
            'detalles.*.producto' => 'required|string',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated, $compra) {
            $monto_total = 0;
            
            foreach ($validated['detalles'] as $detalle) {
                $monto_total += $detalle['cantidad'] * $detalle['precio_unitario'];
            }

            $compra->update([
                'realizado_por' => $validated['realizado_por'],
                'proveedor' => $validated['proveedor'],
                'descripcion' => $validated['descripcion'],
                'monto_total' => $monto_total,
                'fecha_compra' => $validated['fecha_compra'],
                'estado' => $validated['estado'],
                'observaciones' => $validated['observaciones'] ?? null,
            ]);

            $compra->detalles()->delete();

            foreach ($validated['detalles'] as $detalle) {
                DetalleCompra::create([
                    'compra_id' => $compra->id,
                    'producto' => $detalle['producto'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'],
                    'subtotal' => $detalle['cantidad'] * $detalle['precio_unitario'],
                ]);
            }
        });

        return redirect()->route('compras.show', $compra)->with('success', 'Compra actualizada exitosamente');
    }

    public function destroy(Compra $compra)
    {
        $compra->delete();
        return redirect()->route('compras.index')->with('success', 'Compra eliminada exitosamente');
    }
}
