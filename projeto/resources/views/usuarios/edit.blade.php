@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Usuário</h1>
    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('usuarios._form', ['usuario' => $usuario])
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>
@endsection
