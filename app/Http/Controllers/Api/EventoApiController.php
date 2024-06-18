<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class EventoApiController extends Controller
{
    public function index()
    {
        $eventos = Evento::withTrashed()->get();
        return response()->json($eventos);
    }

    public function detalles($id)
    {
        $evento = Evento::withTrashed()->find($id);

        if (!$evento) {
            return response()->json(0);
        }

        return response()->json($evento);
    }


    public function agregar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo' => 'required|in:Llamada,Pago,Revisión',
            'titulo' => 'required|string|max:255',
            'estado' => 'required|in:Pendiente,Cancelado,Terminado',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_aviso',
            'fecha_aviso' => 'nullable|date|before_or_equal:fecha_fin',
            'descripcion' => 'nullable|string',
            'cliente_id' => 'nullable|exists:clientes,id',
            'user_id' => 'required|exists:users,id',
        ], [
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de aviso.',
            'fecha_aviso.before_or_equal' => 'La fecha de aviso debe ser igual o anterior a la fecha de fin.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // Devuelve errores de validación
        }

        try {
            // Crear el evento
            Evento::create($validator->validated());

            return response()->json(['message' => 'Evento agregado correctamente'], 201); // Devuelve un mensaje de éxito
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ha ocurrido un error al agregar el evento'], 500); // Manejo de errores generales
        }
    }

    public function actualizar(Request $request, $id)
    {
        $evento = Evento::withTrashed()->find($id);

        if (!$evento) {
            return response()->json("No existe el evento", 404);
        }

        $validator = Validator::make($request->all(), [
            'tipo' => 'required|in:Llamada,Pago,Revisión',
            'titulo' => 'required|string|max:255',
            'estado' => 'required|in:Pendiente,Cancelado,Terminado',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_aviso',
            'fecha_aviso' => 'nullable|date|before_or_equal:fecha_fin',
            'descripcion' => 'nullable|string',
            'cliente_id' => 'nullable|exists:clientes,id',
            'user_id' => 'required|exists:users,id',
        ], [
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de aviso.',
            'fecha_aviso.before_or_equal' => 'La fecha de aviso debe ser igual o anterior a la fecha de fin.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // Devuelve errores de validación
        }

        try {
            // Actualizar el evento
            $evento->update($validator->validated());

            return response()->json(['message' => 'Evento actualizado correctamente'], 200); // Devuelve un mensaje de éxito
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ha ocurrido un error al actualizar el evento'], 500); // Manejo de errores generales
        }
    }

    public function borrar($id)
    {
        // Recogo el Evento
        $evento = Evento::withTrashed()->find($id);

        // Compruebo que exista
        if (!$evento) {
            return response()->json("No existe el evento", 404);
        }

        // Elimino el Evento
        $evento->delete();

        // Devuelvo la respuesta de confirmación
        return response()->json(['message' => 'Evento borrado correctamente'], 200);
    }

    public function restaurar($id)
    {
        $evento = Evento::withTrashed()->find($id);

        if (!$evento) {
            return response()->json("No existe el evento", 404);
        }

        $evento->restore();

        return response()->json(['message' => 'Evento restaurado correctamente'], 200);
    }
}
