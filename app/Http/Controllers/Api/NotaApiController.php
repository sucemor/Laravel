<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Nota;
use App\Models\NotaAdjunto;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NotaApiController extends Controller
{
    public function index()
    {
        $notas = Nota::withTrashed()->get();
        return response()->json($notas);
    }

    public function detalles($id)
    {
        $nota = Nota::withTrashed()->find($id);

        if (!$nota) {
            return response()->json(0);
        }

        return response()->json($nota);
    }

    public function agregar(Request $request)
    {
        try {
            $validated = $request->validate([
                'titulo' => 'required|string|max:255',
                'cuerpo' => 'required|string',
                'adjuntos.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx',
                'cliente_id' => 'nullable|exists:clientes,id',
            ]);

            $validated['user_id'] = Auth::id(); // Asignar automáticamente el usuario autenticado

            $nota = Nota::create($validated);

            if ($request->hasFile('adjuntos')) {
                foreach ($request->file('adjuntos') as $file) {
                    $path = $file->storeAs('adjuntos', $file->getClientOriginalName(), 'public');
                    NotaAdjunto::create([
                        'nota_id' => $nota->id,
                        'archivo' => $path
                    ]);
                }
            }

            return response()->json(['message' => 'Nota agregada correctamente'], 201); // Devuelve un mensaje de éxito
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422); // Devuelve errores de validación
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ha ocurrido un error al agregar la nota'], 500); // Manejo de errores generales
        }
    }

    public function actualizar(Request $request, $id)
    {
        $nota = Nota::withTrashed()->find($id);

        if (!$nota) {
            return response()->json("No existe la nota", 404);
        }

        try {
            $validated = $request->validate([
                'titulo' => 'required|string|max:255',
                'cuerpo' => 'required|string',
                'adjuntos.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx',
                'cliente_id' => 'nullable|exists:clientes,id',
            ]);

            $nota->update($validated);

            if ($request->hasFile('adjuntos')) {
                foreach ($request->file('adjuntos') as $file) {
                    $path = $file->storeAs('adjuntos', $file->getClientOriginalName(), 'public');
                    NotaAdjunto::create([
                        'nota_id' => $nota->id,
                        'archivo' => $path
                    ]);
                }
            }

            return response()->json(['message' => 'Nota actualizada correctamente'], 200); // Devuelve un mensaje de éxito
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422); // Devuelve errores de validación
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ha ocurrido un error al actualizar la nota'], 500); // Manejo de errores generales
        }
    }

    public function borrar($id)
    {
        $nota = Nota::withTrashed()->find($id);

        if (!$nota) {
            return response()->json("No existe la nota", 404);
        }

        foreach ($nota->adjuntos as $adjunto) {
            Storage::disk('public')->delete($adjunto->archivo);
            $adjunto->delete();
        }

        $nota->delete();

        return response()->json(['message' => 'Nota borrada correctamente'], 200);
    }

    public function restaurar($id)
    {
        $nota = Nota::withTrashed()->find($id);

        if (!$nota) {
            return response()->json("No existe la nota", 404);
        }

        $nota->restore();

        return response()->json(['message' => 'Nota restaurada correctamente'], 200);
    }

    public function descargarAdjunto($id)
    {
        $adjunto = NotaAdjunto::findOrFail($id);

        return response()->download(storage_path("app/public/{$adjunto->archivo}"));
    }
}
