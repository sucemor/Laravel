<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contacto;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ContactoApiController extends Controller
{
    public function index()
    {
        $contactos = Contacto::withTrashed()->get();
        return response()->json($contactos);
    }

    public function detalles($id)
    {
        $contacto = Contacto::withTrashed()->find($id);

        if (!$contacto) {
            return response()->json(0);
        }

        return response()->json($contacto);
    }


    public function agregar(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'telefono1' => 'required|string|max:15',
                'telefono2' => 'nullable|string|max:15',
                'cliente_id' => 'required|exists:clientes,id',
                'email' => 'required|email|unique:contactos',
                'observaciones' => 'nullable|string',
            ]);

            //Creo el contacto
            Contacto::create($validated);

            return response()->json(['message' => 'Contacto agregado correctamente'], 201); // Devuelve un mensaje de éxito
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422); // Devuelve errores de validación
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ha ocurrido un error al agregar el contacto'], 500); // Manejo de errores generales
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
                'nombre' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'telefono1' => 'required|string|max:15',
                'telefono2' => 'nullable|string|max:15',
                'cliente_id' => 'required|exists:clientes,id',
                'email' => 'required|email|unique:contactos,email,' . $id,
                'observaciones' => 'nullable|string',
            ]);

            $contacto = Contacto::withTrashed()->findOrFail($id);
            $contacto->update($validated);

            return response()->json(['message' => 'Contacto actualizado correctamente'], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ha ocurrido un error al actualizar el contacto'], 500);
        }
    }

    public function borrar($id)
    {
        // Recogo el Contacto
        $contacto = Contacto::withTrashed()->find($id);

        // Compruebo que exista
        if (!$contacto) {
            return response()->json("No existe el contacto", 404);
        }

        // Elimino el Contacto
        $contacto->delete();

        // Devuelvo la respuesta de confirmación
        return response()->json(['message' => 'Contacto borrado correctamente'], 200);
    }

    public function restaurar($id)
    {
        $contacto = Contacto::withTrashed()->find($id);

        if (!$contacto) {
            return response()->json("No existe el contacto", 404);
        }

        $contacto->restore();

        return response()->json(['message' => 'Contacto restaurado correctamente'], 200);
    }
}
