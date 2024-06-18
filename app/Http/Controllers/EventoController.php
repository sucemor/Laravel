<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::withTrashed()->get(); // Incluir eventos borrados lógicamente
        return view('eventos.index', compact('eventos'));
    }

    public function create()
    {
        $clientes = Cliente::all(); // Obtener todos los clientes
        return view('eventos.create', compact('clientes')); // Pasar los clientes a la vista
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo' => 'required|in:Llamada,Pago,Revisión',
            'titulo' => 'required|string|max:255',
            'estado' => 'required|in:Pendiente,Cancelado,Terminado',
            'fecha_fin' => 'nullable|date',
            'fecha_aviso' => 'nullable|date',
            'descripcion' => 'nullable|string',
            'cliente_id' => 'nullable|exists:clientes,id',
        ]);

        $validated['user_id'] = Auth::id(); // Asignar automáticamente el usuario autenticado

        Evento::create($validated);

        return redirect()->route('eventos.index');
    }

    public function show(Evento $evento)
    {
        return view('eventos.show', compact('evento'));
    }

    public function edit(Evento $evento)
    {
        $clientes = Cliente::all(); // Obtener todos los clientes
        return view('eventos.edit', compact('evento', 'clientes')); // Pasar los clientes y el evento a la vista
    }

    public function update(Request $request, Evento $evento)
    {
        $validated = $request->validate([
            'tipo' => 'required|in:Llamada,Pago,Revisión',
            'titulo' => 'required|string|max:255',
            'estado' => 'required|in:Pendiente,Cancelado,Terminado',
            'fecha_fin' => 'nullable|date',
            'fecha_aviso' => 'nullable|date',
            'descripcion' => 'nullable|string',
            'cliente_id' => 'nullable|exists:clientes,id',
        ]);

        $evento->update($validated);

        return redirect()->route('eventos.index');
    }

    public function destroy(Evento $evento)
    {
        $evento->delete();

        return redirect()->route('eventos.index');
    }

    public function restore($id)
    {
        $evento = Evento::withTrashed()->findOrFail($id);
        $evento->restore();

        return redirect()->route('eventos.index')->with('success', 'Evento restaurado correctamente.');
    }

    public function indexJson()
    {
        $eventos = Evento::withTrashed()->with('cliente')->get();
        return response()->json($eventos);
    }

    public function showJson($id)
    {
        $evento = Evento::withTrashed()->with('cliente')->findOrFail($id);
        return response()->json($evento);
    }
}
