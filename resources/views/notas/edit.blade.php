@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Editar Nota</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('notas.update', $nota) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" value="{{ $nota->titulo }}" required>
        </div>
        <div class="form-group">
            <label for="cuerpo">Cuerpo</label>
            <textarea name="cuerpo" id="cuerpo" class="form-control" rows="5" required>{{ $nota->cuerpo }}</textarea>
        </div>
        <div class="form-group">
            <label for="adjuntos">Adjuntos</label>
            @if ($nota->adjuntos)
                <div class="mb-2">
                    @foreach ($nota->adjuntos as $adjunto)
                        <p>{{ $adjunto->archivo }}</p>
                    @endforeach
                </div>
            @endif
            <input type="file" name="adjuntos[]" id="adjuntos" class="form-control-file" multiple>
        </div>
        <div class="form-group">
            <label for="cliente_id">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-control">
                <option value="">Ninguno</option>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ $nota->cliente_id == $cliente->id ? 'selected' : '' }}>{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Guardar</button>
    </form>
</div>
@endsection
