<?php

namespace App\Http\Controllers;

use App\Models\Motorista;
use Illuminate\Http\Request;

class MotoristaController extends Controller
{
    /**
     * Exibe a lista de motoristas.
     */
    public function index()
    {
        $motoristas = Motorista::all();
        return view('motoristas.index', compact('motoristas'));
    }

    /**
     * Armazena um novo motorista no banco de dados.
     */
    public function store(Request $request)
    {
        try {
            // Validação dos dados
            $validatedData = $request->validate([
                'nome' => 'required|string|max:255',
                'cnh' => 'required|string|max:20|unique:motoristas,cnh',
                'validade_cnh' => 'required|date',
                'data_nascimento' => 'required|date',
                'endereco' => 'required|string|max:255',
                'telefone' => 'required|string|max:20',
                'email' => 'required|email|max:255|unique:motoristas,email',
            ]);

            // Criando um novo motorista
            Motorista::create($validatedData);

            return redirect()->route('motorista.index')
                ->with('success', 'Motorista cadastrado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('motorista.index')
                ->with('error', 'Erro ao cadastrar motorista. Tente novamente.');
        }
    }

    /**
     * Atualiza um motorista existente.
     */
    public function update(Request $request, $id)
    {
        try {
            // Validação dos dados
            $validatedData = $request->validate([
                'nome' => 'required|string|max:255',
                'cnh' => 'required|string|max:20|unique:motoristas,cnh,' . $id,
                'validade_cnh' => 'required|date',
                'data_nascimento' => 'required|date',
                'endereco' => 'required|string|max:255',
                'telefone' => 'required|string|max:20',
                'email' => 'required|email|max:255|unique:motoristas,email,' . $id,
            ]);

            // Busca o motorista pelo ID
            $motorista = Motorista::findOrFail($id);

            // Atualiza os dados
            $motorista->update($validatedData);

            return redirect()->route('motorista.index')
                ->with('success', 'Motorista atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('motorista.index')
                ->with('error', 'Erro ao atualizar motorista. Tente novamente.');
        }
    }

    /**
     * Remove um motorista do banco de dados.
     */
    public function destroy($id)
    {
        try {
            // Busca o motorista pelo ID
            $motorista = Motorista::findOrFail($id);

            // Deleta o motorista
            $motorista->delete();

            return redirect()->route('motorista.index')
                ->with('success', 'Motorista removido com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('motorista.index')
                ->with('error', 'Erro ao remover motorista. Tente novamente.');
        }
    }
}
