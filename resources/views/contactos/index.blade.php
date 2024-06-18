@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Contactos</h1>
    <a href="{{ route('contactos.create') }}" class="btn btn-primary mb-3">Crear Contacto</a>
    <ul class="list-group">
        @foreach ($contactos as $contacto)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ $contacto->nombre }} {{ $contacto->apellidos }}</h3>
                    <p>{{ $contacto->email }}</p>
                </div>
                <div>
                    <a href="{{ route('contactos.show', $contacto) }}" class="btn btn-info">Ver</a>
                    <a href="{{ route('contactos.edit', $contacto) }}" class="btn btn-warning">Editar</a>
                    @if($contacto->trashed())
                        <form action="{{ route('contactos.restore', $contacto->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success">Restaurar</button>
                        </form>
                    @else
                        <form action="{{ route('contactos.destroy', $contacto) }}" method="POST" class="d-inline">
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
