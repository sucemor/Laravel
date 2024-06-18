@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Crear Nota</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('notas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo') }}" required>
        </div>
        <div class="form-group">
            <label for="cuerpo">Cuerpo</label>
            <textarea name="cuerpo" id="cuerpo" class="form-control" rows="5" required>{{ old('cuerpo') }}</textarea>
        </div>
        <div class="form-group">
            <label for="adjuntos">Adjuntos</label>
            <input type="file" name="adjuntos[]" id="adjuntos" class="form-control-file" multiple>
        </div>
        <div class="form-group">
            <label for="cliente_id">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-control">
                <option value="">Ninguno</option>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Guardar</button>
    </form>
</div>
@endsection
