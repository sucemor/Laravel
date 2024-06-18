<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\NotaAdjunto;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NotaController extends Controller
{
    public function index()
    {
        $notas = Nota::withTrashed()->get(); // Incluir notas borradas lógicamente
        return view('notas.index', compact('notas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        return view('notas.create', compact('clientes'));
    }

    public function store(Request $request)
    {
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

        return redirect()->route('notas.index');
    }

    public function show(Nota $nota)
    {
        return view('notas.show', compact('nota'));
    }

    public function edit(Nota $nota)
    {
        $clientes = Cliente::all();
        return view('notas.edit', compact('nota', 'clientes'));
    }

    public function update(Request $request, Nota $nota)
    {
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

        return redirect()->route('notas.index');
    }

    public function destroy(Nota $nota)
    {
        foreach ($nota->adjuntos as $adjunto) {
            Storage::disk('public')->delete($adjunto->archivo);
            $adjunto->delete();
        }
        $nota->delete();
        return redirect()->route('notas.index');
    }

    public function restore($id)
    {
        $nota = Nota::withTrashed()->findOrFail($id);
        $nota->restore();
        $nota->adjuntos()->withTrashed()->restore();

        return redirect()->route('notas.index')->with('success', 'Nota restaurada correctamente.');
    }

    public function descargarAdjunto($id)
    {
        $adjunto = NotaAdjunto::findOrFail($id);

        return response()->download(storage_path("app/public/{$adjunto->archivo}"));
    }
}
