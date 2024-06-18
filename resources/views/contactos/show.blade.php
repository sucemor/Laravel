@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Detalles del Contacto</h1>
    <div class="card">
        <div class="card-header">
            <h2>{{ $contacto->nombre }} {{ $contacto->apellidos }}</h2>
        </div>
        <div class="card-body">
            <p><strong>Email:</strong> {{ $contacto->email }}</p>
            <p><strong>Teléfono 1:</strong> {{ $contacto->telefono1 }}</p>
            <p><strong>Teléfono 2:</strong> {{ $contacto->telefono2 }}</p>
            <p><strong>Cliente:</strong> {{ $contacto->cliente->nombre }}</p>
            <p><strong>Observaciones:</strong> {{ $contacto->observaciones }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('contactos.edit', $contacto) }}" class="btn btn-warning">Editar</a>
            @if($contacto->trashed())
                <form action="{{ route('contactos.restore', $contacto->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success">Restaurar</button>
                </form>
            @else
                <form action="{{ route('contactos.destroy', $contacto) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            @endif
            <a href="{{ route('contactos.index') }}" class="btn btn-secondary">Volver a la lista</a>
        </div>
    </div>
</div>
@endsection
