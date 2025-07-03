<?php

namespace App\Http\Controllers;

use App\Models\Saida;
use App\Models\Veiculo;
use App\Models\Motorista;
use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    /**
     * Exibe a lista de veículos.
     */
    public function index()
    {
        // Obtém todos os veículos cadastrados
        $veiculos = Veiculo::paginate(10);

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

    public function dashboard()
    {
        // Obtém todos os veículos cadastrados
        $veiculos = Veiculo::all();

        // Retorna a view com os veículos
        return view('veiculos.dashboard', compact('veiculos'));
    }

    public function indexSaida()
    {
        $veiculos = Veiculo::where('em_uso', false)->get();
        $motoristas = Motorista::all();

        return view('veiculos.indexSaida', compact('veiculos', 'motoristas'));
    }

    public function indexRetorno()
    {
        $veiculos = Saida::whereNull('deleted_at')->get();

        return view('veiculos.indexRetorno', compact('veiculos'));
    }

    public function storeSaida(Request $request)
    {
        $data = $request->validate([
            'veiculo_id' => 'required|exists:veiculos,id',
            'motorista_id' => 'required|exists:motoristas,id',
            'km_atual' => 'required|integer',
            'avarias_descritas' => 'nullable|string',
        ]);

        try {
            // 1) Marca o veículo como em uso e atualiza o KM
            $veiculo = Veiculo::findOrFail($data['veiculo_id']);

            $veiculo->update([
                'em_uso' => true,
            ]);

            // 2) Cria o registro de saída
            Saida::create([
                'veiculo_id' => $data['veiculo_id'],
                'motorista_id' => $data['motorista_id'],
                'km_atual' => $data['km_atual'],
                'avarias_descritas' => $data['avarias_descritas'] ?: null,
            ]);

            return redirect()->back()
                ->with('success', 'Saída registrada com sucesso.');
        } catch (\Exception $e) {
            \Log::error('Erro ao registrar saída: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Ocorreu um erro ao registrar a saída.');
        }
    }

    public function storeRetorno(Request $request)
    {
        $data = $request->validate([
            'saida_id' => 'required|exists:saidas,id',
            'km_atual' => 'required|integer',
            'notas_retorno' => 'nullable|string',
        ]);

        try {
            // 1) Recupera a saída e marca como retornada (soft delete)
            $saida = Saida::findOrFail($data['saida_id']);
            $saida->deleted_at = now();
            $saida->nota_retorno = $data['notas_retorno'] ?? null;
            $saida->save();

            // 2) Atualiza o veículo: libera e ajusta KM
            $veiculo = $saida->veiculo;
            $veiculo->update([
                'em_uso' => false,
                'km_atual' => $data['km_atual'],
            ]);

            return redirect()->back()
                ->with('success', 'Retorno registrado com sucesso.');
        } catch (\Exception $e) {
            \Log::error('Erro ao registrar retorno: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Ocorreu um erro ao registrar o retorno.');
        }
    }

}
