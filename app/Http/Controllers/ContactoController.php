<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    // Muestra una lista de todos los contactos, excluyendo los contactos eliminados lógicamente
    public function index()
    {
        $contactos = Contacto::withoutTrashed()->get(); // Excluir contactos borrados lógicamente
        return view('contactos.index', compact('contactos'));
    }


    // Muestra el formulario para crear un nuevo contacto
    public function create()
    {
        $clientes = Cliente::all(); // Obtener todos los clientes
        return view('contactos.create', compact('clientes')); // Pasar los clientes a la vista
    }

    // Almacena un nuevo contacto en la base de datos
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono1' => 'required|string|max:15',
            'telefono2' => 'nullable|string|max:15',
            'cliente_id' => 'required|exists:clientes,id',
            'email' => 'required|email|unique:contactos',
            'observaciones' => 'nullable|string',
        ]);

        Contacto::create($validated);

        return redirect()->route('contactos.index');
    }

    // Muestra los detalles de un contacto específico
    public function show(Contacto $contacto)
    {
        return view('contactos.show', compact('contacto'));
    }

    // Muestra el formulario para editar un contacto existente
    public function edit(Contacto $contacto)
    {
        $clientes = Cliente::all(); // Obtener todos los clientes
        return view('contactos.edit', compact('contacto', 'clientes')); // Pasar los clientes a la vista
    }

    // Actualiza un contacto existente en la base de datos
    public function update(Request $request, Contacto $contacto)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono1' => 'required|string|max:15',
            'telefono2' => 'nullable|string|max:15',
            'cliente_id' => 'required|exists:clientes,id',
            'email' => 'required|email|unique:contactos,email,' . $contacto->id,
            'observaciones' => 'nullable|string',
        ]);

        $contacto->update($validated);

        return redirect()->route('contactos.index');
    }

    // Elimina lógicamente un contacto de la base de datos
    public function destroy(Contacto $contacto)
    {
        $contacto->delete();
        return redirect()->route('contactos.index');
    }

    // Restaura un contacto eliminado lógicamente
    public function restore($id)
    {
        $contacto = Contacto::withTrashed()->findOrFail($id);
        $contacto->restore();

        return redirect()->route('contactos.index')->with('success', 'Contacto restaurado correctamente.');
    }

    // Devuelve una lista de todos los contactos en formato JSON, excluyendo los contactos eliminados lógicamente
    public function indexJson()
    {
        $contactos = Contacto::withoutTrashed()->get(); // Excluir contactos borrados lógicamente
        return response()->json($contactos);
    }

    // Devuelve los detalles de un contacto específico en formato JSON, excluyendo los contactos eliminados lógicamente
    public function showJson($id)
    {
        $contacto = Contacto::withoutTrashed()->findOrFail($id); // Excluir contactos borrados lógicamente
        return response()->json($contacto);
    }
}
