@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Detalles del Cliente</h1>
    <div class="card mb-4">
        <div class="card-header">
            <h2>{{ $cliente->nombre }}</h2>
        </div>
        <div class="card-body">
            <p><strong>Email:</strong> {{ $cliente->email }}</p>
            <p><strong>Teléfono 1:</strong> {{ $cliente->telefono1 }}</p>
            <p><strong>Teléfono 2:</strong> {{ $cliente->telefono2 }}</p>
            <p><strong>Tipo de Empresa:</strong> {{ $cliente->tipo_empresa }}</p>
            <p><strong>Persona a Cargo:</strong> {{ $cliente->user->name }}</p>
            <p><strong>Web:</strong> <a href="{{ $cliente->web }}" target="_blank">{{ $cliente->web }}</a></p>
            <p><strong>Dirección:</strong> {{ $cliente->direccion }}</p>
            <p><strong>Ciudad:</strong> {{ $cliente->ciudad }}</p>
            <p><strong>Provincia:</strong> {{ $cliente->provincia }}</p>
            <p><strong>País:</strong> {{ $cliente->pais }}</p>
            <p><strong>Código Postal:</strong> {{ $cliente->codigo_postal }}</p>
            <p><strong>Fecha de Creación:</strong> {{ $cliente->fecha_creacion }}</p> <!-- Mostrar fecha de creación -->
            <p><strong>Observaciones:</strong> {{ $cliente->observaciones }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning">Editar</a>
            @if($cliente->trashed())
                <form action="{{ route('clientes.restore', $cliente->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success">Restaurar</button>
                </form>
            @else
                <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            @endif
            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Volver a la lista</a>
        </div>
    </div>
</div>
@endsection