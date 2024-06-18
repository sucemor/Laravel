@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Crear Evento</h1>
    <form action="{{ route('eventos.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="tipo">Tipo:</label>
            <select name="tipo" id="tipo" class="form-control">
                <option value="Llamada">Llamada</option>
                <option value="Pago">Pago</option>
                <option value="Revisión">Revisión</option>
            </select>
        </div>
        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" class="form-control">
        </div>
        <div class="form-group">
            <label for="estado">Estado:</label>
            <select name="estado" id="estado" class="form-control">
                <option value="Pendiente">Pendiente</option>
                <option value="Cancelado">Cancelado</option>
                <option value="Terminado">Terminado</option>
            </select>
        </div>
        <div class="form-group">
            <label for="fecha_fin">Fecha Fin:</label>
            <input type="datetime-local" name="fecha_fin" id="fecha_fin" class="form-control">
        </div>
        <div class="form-group">
            <label for="fecha_aviso">Fecha Aviso:</label>
            <input type="datetime-local" name="fecha_aviso" id="fecha_aviso" class="form-control">
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="cliente_id">Cliente:</label>
            <select name="cliente_id" id="cliente_id" class="form-control">
                <option value="">Ninguno</option>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
