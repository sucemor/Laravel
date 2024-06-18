@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h1>{{ $nota->titulo }}</h1>
        </div>
        <div class="card-body">
            <p>{{ $nota->cuerpo }}</p>
            @if ($nota->adjuntos)
                <p><strong>Adjuntos:</strong></p>
                <ul>
                    @foreach ($nota->adjuntos as $adjunto)
                        <li>
                            <a href="{{ url('api/notas/descargar/'.$adjunto->id) }}" target="_blank">{{ $adjunto->archivo }}</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p><strong>Adjuntos:</strong> No tiene adjuntos</p>
            @endif
            <p><strong>Cliente:</strong> {{ $nota->cliente ? $nota->cliente->nombre : 'Ninguno' }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('notas.edit', $nota) }}" class="btn btn-primary">Editar</a>
            <form action="{{ route('notas.destroy', $nota) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
            <a href="{{ route('notas.index') }}" class="btn btn-secondary">Volver a la lista</a>
        </div>
    </div>
</div>
@endsection
