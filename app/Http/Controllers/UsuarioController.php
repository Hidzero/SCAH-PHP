<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;

class UsuarioController extends Controller
{
    public function index()
    {
        $currentRole = Auth::user()->role;

        if ($currentRole === 'admin') {
            // Admins see only estoque, manutencao e veiculos
            $usuarios = User::whereIn('role', ['estoque', 'manutencao', 'veiculos'])->get();
        } else {
            // Master and others see todos
            $usuarios = User::all();
        }

        return view('usuario.index', compact('usuarios'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'role' => 'required|in:master,admin,estoque,manutencao,veiculos', // Verifica se o valor é válido
            ]);
            // dd($request);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make(Str::random(40)),
            ]);

            Password::broker()->sendResetLink([
                'email' => $user->email,
            ]);

            // dispara o evento (se você precisar)
            event(new Registered($user));

            return redirect()->route('usuario.index')->with('success', 'Usuario cadastrado com sucesso');
        } catch (Exception $e) {
            return redirect()->route('usuario.index')->with('error', 'Erro ao cadastrar usuario. Tente novamente.');
        }
    }

    public function update(Request $request, $id)
    {
        $validRoles = ['master','admin','estoque','manutencao','veiculos'];

        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => "required|string|email|max:255|unique:users,email,$id",
            'role'  => ['required', Rule::in($validRoles)],
        ]);

        try {
            $user = User::findOrFail($id);
            $user->update($data);

            return redirect()
                ->route('usuario.index')
                ->with('success', 'Usuário atualizado com sucesso!');
        } catch (Exception $e) {
            return redirect()
                ->route('usuario.index')
                ->with('error', 'Erro ao atualizar usuário. Tente novamente.');
        }
    }

    public function destroy($id)
    {
        try {
            User::findOrFail($id)->delete();
            return redirect()
                ->route('usuario.index')
                ->with('success', 'Usuário removido com sucesso!');
        } catch (Exception $e) {
            return redirect()
                ->route('usuario.index')
                ->with('error', 'Erro ao remover usuário. Tente novamente.');
        }
    }

}
