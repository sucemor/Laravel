@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>{{ $user->name }}</h1>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Tipo:</strong> {{ $user->tipo }}</p>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Volver a la lista</a>
</div>
@endsection
