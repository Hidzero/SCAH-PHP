<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    /**
     * Exibe a lista de veículos.
     */
    public function index()
    {
        // Obtém todos os veículos cadastrados
        $veiculos = Veiculo::all();

        // Retorna a view com os veículos
        return view('veiculos.index', compact('veiculos'));
    }

    /**
     * Armazena um novo veículo no banco de dados.
     */
    public function store(Request $request)
    {
        try {
            // Validação dos dados do formulário
            $validatedData = $request->validate([
                'nome' => 'required|string|max:255',
                'tipo' => 'required|in:Carro,Caminhão',
                'modelo' => 'required|string|max:255',
                'marca' => 'required|string|max:255',
                'placa' => 'required|string|max:20|unique:veiculos,placa',
                'km_atual' => 'required|integer|min:0',
            ]);

            // Cria o veículo
            Veiculo::create($validatedData);

            // Redireciona com mensagem de sucesso
            return redirect()->route('veiculo.index')
                ->with('success', 'Veículo cadastrado com sucesso!');
        } catch (\Exception $e) {
            // Redireciona com mensagem de erro
            return redirect()->route('veiculo.index')
                ->with('error', 'Não foi possível cadastrar o veículo. Tente novamente.');
        }
    }

    /**
     * Atualiza os dados de um veículo existente.
     */
    public function update(Request $request, $id)
    {
        try {
            // Validação dos dados enviados
            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'tipo' => 'required|in:Carro,Caminhão',
                'modelo' => 'required|string|max:255',
                'marca' => 'required|string|max:255',
                'placa' => "required|string|max:20|unique:veiculos,placa,{$id}",
                'km_atual' => 'required|integer|min:0',
            ]);

            // Busca o veículo pelo ID
            $veiculo = Veiculo::findOrFail($id);

            // Atualiza os dados
            $veiculo->update($validated);

            // Redireciona com mensagem de sucesso
            return redirect()->route('veiculo.index')
                ->with('success', 'Veículo atualizado com sucesso!');
        } catch (\Exception $e) {
            // Redireciona com mensagem de erro
            return redirect()->route('veiculo.index')
                ->with('error', 'Não foi possível atualizar o veículo. Tente novamente.');
        }
    }

    /**
     * Remove um veículo do banco de dados.
     */
    public function destroy($id)
    {
        try {
            // Busca o veículo pelo ID
            $veiculo = Veiculo::findOrFail($id);

            // Deleta o veículo
            $veiculo->delete();

            // Redireciona com mensagem de sucesso
            return redirect()->route('veiculo.index')
                ->with('success', 'Veículo deletado com sucesso!');
        } catch (\Exception $e) {
            // Redireciona com mensagem de erro
            return redirect()->route('veiculo.index')
                ->with('error', 'Não foi possível deletar o veículo. Tente novamente.');
        }
    }
}
