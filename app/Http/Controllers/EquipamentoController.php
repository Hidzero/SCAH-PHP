<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use Illuminate\Http\Request;

class EquipamentoController extends Controller
{
    /**
     * Exibe a lista de equipamentos.
     */
    public function index()
    {
        $equipamentos = Equipamento::all();
        return view('equipamentos.index', compact('equipamentos'));
    }

    /**
     * Armazena um novo equipamento no banco de dados.
     */
    public function store(Request $request)
    {
        try {
            // Validação dos dados
            $validatedData = $request->validate([
                'nome' => 'required|string|max:255',
                'tipo' => 'required|string|max:255',
            ]);

            // Criando um novo equipamento
            Equipamento::create($validatedData);

            return redirect()->route('equipamentos.index')
                ->with('success', 'Equipamento cadastrado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('equipamentos.index')
                ->with('error', 'Erro ao cadastrar equipamento. Tente novamente.');
        }
    }

    /**
     * Atualiza um equipamento existente.
     */
    public function update(Request $request, $id)
    {
        try {
            // Validação dos dados
            $validatedData = $request->validate([
                'nome' => 'required|string|max:255',
                'tipo' => 'required|string|max:255',
            ]);

            // Busca o equipamento pelo ID
            $equipamento = Equipamento::findOrFail($id);

            // Atualiza os dados
            $equipamento->update($validatedData);

            return redirect()->route('equipamentos.index')
                ->with('success', 'Equipamento atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('equipamentos.index')
                ->with('error', 'Erro ao atualizar equipamento. Tente novamente.');
        }
    }

    /**
     * Remove um equipamento do banco de dados.
     */
    public function destroy($id)
    {
        try {
            // Busca o equipamento pelo ID
            $equipamento = Equipamento::findOrFail($id);

            // Deleta o equipamento
            $equipamento->delete();

            return redirect()->route('equipamentos.index')
                ->with('success', 'Equipamento removido com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('equipamentos.index')
                ->with('error', 'Erro ao remover equipamento. Tente novamente.');
        }
    }
}
