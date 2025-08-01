<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Listar todos os usuários
    public function index(Request $request)
    {
        $busca = $request->input('busca');

        $usuarios = User::when($busca, function ($query, $busca) {
            return $query->where('name', 'like', "%{$busca}%")
                        ->orWhere('email', 'like', "%{$busca}%");
        })->get();

        return view('usuarios.index', compact('usuarios', 'busca'));
    }

    // Formulário de criação
    public function create()
    {
        return view('usuarios.create');
    }

    // Salvar novo usuário
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->blocked = false;
        $user->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuário criado com sucesso!');
    }

    // Formulário de edição
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('usuarios.edit', compact('usuario'));
    }

    // Atualizar usuário
    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$usuario->id}",
        ]);

        $usuario->name = $validated['name'];
        $usuario->email = $validated['email'];
        $usuario->blocked = $request->has('blocked');
        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    // Excluir usuário
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuário excluído com sucesso!');
    }
}
