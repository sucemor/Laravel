@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Notas</h1>
    <a href="{{ route('notas.create') }}" class="btn btn-primary mb-3">Crear Nota</a>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Título</th>
                <th>Cuerpo</th>
                <th>Adjuntos</th>
                <th>Cliente</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notas as $nota)
            <tr>
                <td><a href="{{ route('notas.show', $nota) }}" class="link-info">{{ $nota->titulo }}</a></td>
                <td>{{ Str::limit($nota->cuerpo, 50) }}</td>
                <td>
                    @if ($nota->adjuntos)
                        <ul>
                            @foreach ($nota->adjuntos as $adjunto)
                                <li>
                                    <a href="{{ url('api/notas/descargar/'.$adjunto->id) }}" target="_blank">{{ $adjunto->archivo }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        No tiene adjuntos
                    @endif
                </td>
                <td>{{ $nota->cliente ? $nota->cliente->nombre : 'Ninguno' }}</td>
                <td>
                    <a href="{{ route('notas.edit', $nota) }}" class="btn btn-warning btn-sm">Editar</a>
                    @if($nota->trashed())
                        <form action="{{ route('notas.restore', $nota->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success btn-sm">Restaurar</button>
                        </form>
                    @else
                        <form action="{{ route('notas.destroy', $nota) }}" method="POST" class="d-inline">
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
