<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::all();

        return view('usuario.index', compact('usuarios'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|in:usuario,admin,master', // Verifica se o valor é válido
            ]);
        
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role, // Salva a role
            ]);
    
            event(new Registered($user));
    
            Auth::login($user);
    
            return redirect()->route('usuario.index')->with('sucess', 'Usuario cadastrado com sucesso');
        } catch (Exception $e) {
            return redirect()->route('usuario.index')->with('error', 'Erro ao cadastrar usuario. Tente novamente.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // dd($request);

            // Validação dos dados enviados
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => "required|string|email|max:255|unique:users,email,$id",
                'role' => 'required|in:usuario,admin,master', // Garante que a role seja válida
            ]);
    
            // Busca o usuário pelo ID
            $user = User::findOrFail($id);
    
            // Atualiza os dados do usuário
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role']
            ]);
    
            // Retorna para a listagem com mensagem de sucesso
            return redirect()->route('usuario.index')->with('success', 'Usuário atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('usuario.index')->with('error', 'Erro ao atualizar usuário. Tente novamente.');
        }
    }

    public function destroy($id)
    {
        try {
            // Busca o motorista pelo ID
            $usuario = User::findOrFail($id);

            // Deleta o motorista
            $usuario->delete();

            return redirect()->route('usuario.index')
                ->with('success', 'Usuario removido com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('usuario.index')
                ->with('error', 'Erro ao remover usuario. Tente novamente.');
        }
    }
    
}
