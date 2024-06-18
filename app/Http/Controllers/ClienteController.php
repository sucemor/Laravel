<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::withTrashed()->get(); // Incluir clientes borrados lógicamente
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        $users = User::all(); // Obtener todos los usuarios
        return view('clientes.create', compact('users')); // Pasar los usuarios a la vista
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clientes',
            'telefono1' => 'nullable|string|max:15',
            'telefono2' => 'nullable|string|max:15',
            'tipo_empresa' => 'nullable|string|max:20',
            'user_id' => 'nullable|exists:users,id',
            'web' => 'nullable|url',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'provincia' => 'nullable|string|max:100',
            'pais' => 'nullable|string|max:100',
            'codigo_postal' => 'nullable|string|max:20',
            'observaciones' => 'nullable|string',
            'estado' => 'required|in:contactar,posible,acuerdo,terminado,cancelado'
        ]);

        Cliente::create($validated);

        return redirect()->route('clientes.index');
    }

    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        $users = User::all(); // Obtener todos los usuarios
        return view('clientes.edit', compact('cliente', 'users')); // Pasar los usuarios y el cliente a la vista
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clientes,email,' . $cliente->id,
            'telefono1' => 'nullable|string|max:15',
            'telefono2' => 'nullable|string|max:15',
            'tipo_empresa' => 'nullable|string|max:20',
            'user_id' => 'nullable|exists:users,id',
            'web' => 'nullable|url',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'provincia' => 'nullable|string|max:100',
            'pais' => 'nullable|string|max:100',
            'codigo_postal' => 'nullable|string|max:20',
            'observaciones' => 'nullable|string',
            'estado' => 'required|in:contactar,posible,acuerdo,terminado,cancelado'
        ]);

        $cliente->update($validated);

        return redirect()->route('clientes.index');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('clientes.index');
    }

    public function restore($id)
    {
        $cliente = Cliente::withTrashed()->findOrFail($id);
        $cliente->restore();

        return redirect()->route('clientes.index')->with('success', 'Cliente restaurado correctamente.');
    }
}
