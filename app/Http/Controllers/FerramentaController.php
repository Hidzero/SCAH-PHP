<?php

namespace App\Http\Controllers;

use App\Models\Ferramenta;
use Illuminate\Http\Request;

class FerramentaController extends Controller
{
    public function index()
    {
        // Pega 10 ferramentas por página
        $ferramentas = Ferramenta::paginate(10);

        return view('ferramentas.index', compact('ferramentas'));
    }

    public function store(Request $request)
    {
        try {
            // Validação dos dados do formulário
            $validatedData = $request->validate([
                'nome' => 'required|string|max:255',
                'descricao' => 'required|string',
                'numero_serie' => 'required|string|max:255',
            ]);

            // Cria a ferramenta usando atribuição em massa
            Ferramenta::create($validatedData);

            // Redireciona de volta para a lista com uma mensagem de sucesso
            return redirect()->route('ferramentas.index')
                ->with('success', 'Ferramenta cadastrada com sucesso!');
        } catch (Exception $e) {
            // Caso ocorra um erro, redireciona para a listagem com uma mensagem de erro
            return redirect()->route('ferramentas.index')
                ->with('error', 'Não foi possível cadastrar a ferramenta. Tente novamente.');
        }

    }

    public function update(Request $request, $id)
    {
        try {
            // Validação dos dados enviados
            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'descricao' => 'required|string',
                'numero_serie' => 'required|string|max:100',
            ]);

            // Busca a ferramenta pelo id ou retorna 404 se não encontrar
            $ferramenta = Ferramenta::findOrFail($id);

            // Atualiza os dados
            $ferramenta->update($validated);

            // Redireciona para a listagem com uma mensagem de sucesso
            return redirect()->route('ferramentas.index')->with('success', 'Ferramenta atualizada com sucesso!');
        } catch (\Exception $e) {
            // Caso ocorra um erro, redireciona para a listagem com uma mensagem de erro
            return redirect()->route('ferramentas.index')
                ->with('error', 'Não foi possível atualizar a ferramenta. Tente novamente.');
        }

    }

    public function destroy($id)
    {
        try {
            // Busca a ferramenta pelo id, ou lança um erro 404 se não for encontrada
            $ferramenta = Ferramenta::findOrFail($id);

            // Deleta a ferramenta
            $ferramenta->delete();

            // Redireciona para a listagem com uma mensagem de sucesso
            return redirect()->route('ferramentas.index')
                ->with('success', 'Ferramenta deletada com sucesso!');
        } catch (\Exception $e) {
            // Caso ocorra um erro, redireciona para a listagem com uma mensagem de erro
            return redirect()->route('ferramentas.index')
                ->with('error', 'Não foi possível deletar a ferramenta. Tente novamente.');
        }
    }

}
