@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Editar Evento</h1>
    <form action="{{ route('eventos.update', $evento) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="tipo">Tipo:</label>
            <select name="tipo" id="tipo" class="form-control">
                <option value="Llamada" {{ $evento->tipo == 'Llamada' ? 'selected' : '' }}>Llamada</option>
                <option value="Pago" {{ $evento->tipo == 'Pago' ? 'selected' : '' }}>Pago</option>
                <option value="Revisión" {{ $evento->tipo == 'Revisión' ? 'selected' : '' }}>Revisión</option>
            </select>
        </div>
        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" class="form-control" value="{{ $evento->titulo }}">
        </div>
        <div class="form-group">
            <label for="estado">Estado:</label>
            <select name="estado" id="estado" class="form-control">
                <option value="Pendiente" {{ $evento->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="Cancelado" {{ $evento->estado == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                <option value="Terminado" {{ $evento->estado == 'Terminado' ? 'selected' : '' }}>Terminado</option>
            </select>
        </div>
        <div class="form-group">
            <label for="fecha_fin">Fecha Fin:</label>
            <input type="datetime-local" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ $evento->fecha_fin ? $evento->fecha_fin->format('Y-m-d\TH:i') : '' }}">
        </div>
        <div class="form-group">
            <label for="fecha_aviso">Fecha Aviso:</label>
            <input type="datetime-local" name="fecha_aviso" id="fecha_aviso" class="form-control" value="{{ $evento->fecha_aviso ? $evento->fecha_aviso->format('Y-m-d\TH:i') : '' }}">
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" class="form-control">{{ $evento->descripcion }}</textarea>
        </div>
        <div class="form-group">
            <label for="cliente_id">Cliente:</label>
            <select name="cliente_id" id="cliente_id" class="form-control">
                <option value="">Ninguno</option>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ $evento->cliente_id == $cliente->id ? 'selected' : '' }}>{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
