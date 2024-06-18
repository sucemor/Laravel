@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h1>{{ $evento->titulo }}</h1>
        </div>
        <div class="card-body">
            <p><strong>Tipo:</strong> {{ $evento->tipo }}</p>
            <p><strong>Estado:</strong> {{ $evento->estado }}</p>
            <p><strong>Fecha Fin:</strong> {{ $evento->fecha_fin }}</p>
            <p><strong>Fecha Aviso:</strong> {{ $evento->fecha_aviso }}</p>
            <p><strong>Descripción:</strong> {{ $evento->descripcion }}</p>
            <p><strong>Cliente:</strong> {{ $evento->cliente ? $evento->cliente->nombre : 'Ninguno' }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('eventos.edit', $evento) }}" class="btn btn-primary">Editar</a>
            @if($evento->trashed())
                <form action="{{ route('eventos.restore', $evento->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success">Restaurar</button>
                </form>
            @else
                <form action="{{ route('eventos.destroy', $evento) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            @endif
            <a href="{{ route('eventos.index') }}" class="btn btn-secondary">Volver a la lista</a>
        </div>
    </div>
</div>
@endsection
