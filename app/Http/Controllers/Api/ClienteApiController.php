<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ClienteApiController extends Controller
{
    public function index()
    {
        $clientes = Cliente::withTrashed()->get();
        return response()->json($clientes);
    }

    public function detalles($id)
    {
        $cliente = Cliente::withTrashed()->find($id);

        if (!$cliente) {
            return response()->json(0);
        }

        return response()->json($cliente);
    }

    public function agregar(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|unique:clientes|max:255',
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

            //Creo el cliente
            Cliente::create($validated);

            return response()->json(['message' => 'Cliente agregado correctamente'], 201); // Devuelve un mensaje de éxito
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422); // Devuelve errores de validación
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ha ocurrido un error al agregar el cliente'], 500); // Manejo de errores generales
        }
    }

    public function actualizar(Request $request, $id)
    {
        // Primero tengo que comprobar que exista para eso uso detalles
        if (!$this->detalles($id)) {
            return response()->json("No existe", 404); // Devolver un código de estado 404
        }
        // Si existe pruebo a actualizar
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|unique:clientes|max:255',
                'email' => 'nullable|email|unique:clientes,email,' . $id,
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

            $cliente = Cliente::withTrashed()->findOrFail($id);
            $cliente->update($validated);

            return response()->json(['message' => 'Cliente actualizado correctamente'], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ha ocurrido un error al actualizar el cliente'], 500);
        }
    }

    public function borrar($id)
    {
        // Recogo el Cliente
        $cliente = Cliente::withTrashed()->find($id);

        // Compruebo que exista
        if (!$cliente) {
            return response()->json("No existe el cliente", 404);
        }

        // Elimino el Cliente
        $cliente->delete();

        // Devuelvo la respuesta de confirmación
        return response()->json(['message' => 'Cliente borrado correctamente'], 200);
    }

    public function restaurar($id)
    {
        $cliente = Cliente::withTrashed()->find($id);

        if (!$cliente) {
            return response()->json("No existe el cliente", 404);
        }

        $cliente->restore();

        return response()->json(['message' => 'Cliente restaurado correctamente'], 200);
    }
}
