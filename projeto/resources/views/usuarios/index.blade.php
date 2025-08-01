@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Usuários</h1>

    <a href="{{ route('usuarios.create') }}" class="btn btn-primary mb-3">Adicionar Usuário</a>

    <form method="GET" action="{{ route('usuarios.index') }}" class="mb-3 d-flex">
        <input type="text" name="busca" class="form-control me-2" placeholder="Buscar por nome ou email" value="{{ $busca ?? '' }}">
        <button type="submit" class="btn btn-secondary">Buscar</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Bloqueado?</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->blocked ? 'Sim' : 'Não' }}</td>
                    <td>
                        <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Tem certeza que deseja excluir?')" class="btn btn-sm btn-danger">
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
