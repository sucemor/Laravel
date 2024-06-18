@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Usuarios</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Crear Usuario</a>
    <ul class="list-group">
        @foreach ($users as $user)
            <li class="list-group-item">
                <h3>{{ $user->name }}</h3>
                <p>{{ $user->email }}</p>
                <div class="mt-2">
                    <a href="{{ route('users.show', $user) }}" class="btn btn-info">Ver</a>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">Editar</a>
                    @if($user->trashed())
                        <form action="{{ route('users.restore', $user) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success">Restaurar</button>
                        </form>
                    @else
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
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
