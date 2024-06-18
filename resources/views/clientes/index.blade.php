@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Clientes</h1>
    <a href="{{ route('clientes.create') }}" class="btn btn-primary mb-3">Crear Cliente</a>
    <a href="{{ url('api/clientes') }}" class="btn btn-secondary mb-3" target="_blank">Ver JSON</a> <!-- Botón para ver JSON -->
    <ul class="list-group">
        @foreach ($clientes as $cliente)
            <li class="list-group-item mb-3">
                <h3>{{ $cliente->nombre }}</h3>
                <p>{{ $cliente->email }}</p>
                <p><strong>Fecha de Creación:</strong> {{ $cliente->fecha_creacion }}</p> <!-- Mostrar fecha de creación -->
                <div class="mt-2">
                    <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-info">Ver</a>
                    <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning">Editar</a>
                    @if($cliente->trashed())
                        <form action="{{ route('clientes.restore', $cliente) }}" method="POST" class="d-inline">
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
                </div>
            </li>
        @endforeach
    </ul>
</div>
@endsection