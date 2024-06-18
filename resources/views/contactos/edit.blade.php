@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Editar Contacto</h1>
    <form action="{{ route('contactos.update', $contacto) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $contacto->nombre }}" required>
        </div>
        <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{ $contacto->apellidos }}" required>
        </div>
        <div class="form-group">
            <label for="telefono1">Teléfono 1</label>
            <input type="text" class="form-control" id="telefono1" name="telefono1" value="{{ $contacto->telefono1 }}" required>
        </div>
        <div class="form-group">
            <label for="telefono2">Teléfono 2</label>
            <input type="text" class="form-control" id="telefono2" name="telefono2" value="{{ $contacto->telefono2 }}">
        </div>
        <div class="form-group">
            <label for="cliente_id">Cliente</label>
            <select class="form-control" id="cliente_id" name="cliente_id" required>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" @if($cliente->id == $contacto->cliente_id) selected @endif>{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="email">Correo</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $contacto->email }}" required>
        </div>
        <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones">{{ $contacto->observaciones }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
