@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Eventos</h1>
    <a href="{{ route('eventos.create') }}" class="btn btn-primary mb-3">Crear Evento</a>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Título</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($eventos as $evento)
            <tr>
                <td><a href="{{ route('eventos.show', $evento) }}" class="link-info">{{ $evento->titulo }}</a></td>
                <td>{{ $evento->tipo }}</td>
                <td>{{ $evento->estado }}</td>
                <td>
                    <a href="{{ route('eventos.edit', $evento) }}" class="btn btn-warning btn-sm">Editar</a>
                    @if($evento->trashed())
                        <form action="{{ route('eventos.restore', $evento->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success btn-sm">Restaurar</button>
                        </form>
                    @else
                        <form action="{{ route('eventos.destroy', $evento) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
