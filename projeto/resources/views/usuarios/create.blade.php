@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Criar Novo Usuário</h1>
    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        @include('usuarios._form', ['usuario' => null])
        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
</div>
@endsection
