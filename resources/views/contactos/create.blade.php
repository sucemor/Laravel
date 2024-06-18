@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Crear Contacto</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contactos.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
            @error('nombre')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input type="text" class="form-control @error('apellidos') is-invalid @enderror" id="apellidos" name="apellidos" value="{{ old('apellidos') }}" required>
            @error('apellidos')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="telefono1">Teléfono 1</label>
            <input type="text" class="form-control @error('telefono1') is-invalid @enderror" id="telefono1" name="telefono1" value="{{ old('telefono1') }}" required>
            @error('telefono1')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="telefono2">Teléfono 2</label>
            <input type="text" class="form-control @error('telefono2') is-invalid @enderror" id="telefono2" name="telefono2" value="{{ old('telefono2') }}">
            @error('telefono2')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="cliente_id">Cliente</label>
            <select class="form-control @error('cliente_id') is-invalid @enderror" id="cliente_id" name="cliente_id" required>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>{{ $cliente->nombre }}</option>
                @endforeach
            </select>
            @error('cliente_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Correo</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <textarea class="form-control @error('observaciones') is-invalid @enderror" id="observaciones" name="observaciones">{{ old('observaciones') }}</textarea>
            @error('observaciones')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
