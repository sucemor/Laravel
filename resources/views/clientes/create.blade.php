@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Crear Cliente</h1>
    <form action="{{ route('clientes.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="email">Correo</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="telefono1">Teléfono 1</label>
            <input type="text" class="form-control" id="telefono1" name="telefono1" value="{{ old('telefono1') }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="telefono2">Teléfono 2</label>
            <input type="text" class="form-control" id="telefono2" name="telefono2" value="{{ old('telefono2') }}">
        </div>
        <div class="form-group mb-3">
            <label for="tipo_empresa">Tipo de Empresa</label>
            <input type="text" class="form-control" id="tipo_empresa" name="tipo_empresa" value="{{ old('tipo_empresa') }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="user_id">Usuario</label>
            <select name="user_id" id="user_id" class="form-control" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="web">Sitio Web</label>
            <input type="url" class="form-control" id="web" name="web" value="{{ old('web') }}">
        </div>
        <div class="form-group mb-3">
            <label for="direccion">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion') }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="ciudad">Ciudad</label>
            <input type="text" class="form-control" id="ciudad" name="ciudad" value="{{ old('ciudad') }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="provincia">Provincia</label>
            <input type="text" class="form-control" id="provincia" name="provincia" value="{{ old('provincia') }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="pais">País</label>
            <input type="text" class="form-control" id="pais" name="pais" value="{{ old('pais') }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="codigo_postal">Código Postal</label>
            <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" value="{{ old('codigo_postal') }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="fecha_creacion">Fecha de Creación</label>
            <input type="date" class="form-control" id="fecha_creacion" name="fecha_creacion" value="{{ old('fecha_creacion') }}">
        </div>
        <div class="form-group mb-3">
            <label for="observaciones">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones">{{ old('observaciones') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
