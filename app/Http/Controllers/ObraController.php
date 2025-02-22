<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use Illuminate\Http\Request;

class ObraController extends Controller
{
    public function index()
    {
        // Recupera todas as obras do banco de dados
        $obras = Obra::all();

        // Retorna a view 'obras.index' com os dados
        return view('obras.index', compact('obras'));
    }

    public function store(Request $request)
    {
        try {
            // Validação dos dados do formulário
            $validatedData = $request->validate([
                'cliente' => 'required|string|max:255',
                'endereco' => 'required|string|max:255',
                'inicio_obra' => 'required|date',
                'fim_obra' => 'nullable|date|after_or_equal:inicio_obra',
            ]);
    
            // Cria a obra usando atribuição em massa
            Obra::create($validatedData);
    
            // Redireciona com uma mensagem de sucesso
            return redirect()->route('obra.index')
                ->with('success', 'Obra cadastrada com sucesso!');
        } catch (\Exception $e) {
            // Redireciona com uma mensagem de erro
            return redirect()->route('obra.index')
                ->with('error', 'Não foi possível cadastrar a obra. Tente novamente.');
        }
    }
    
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'cliente' => 'required|string|max:255',
                'endereco' => 'required|string|max:255',
                'inicio_obra' => 'required|date',
                'fim_obra' => 'nullable|date|after_or_equal:inicio_obra',
            ], [
                'fim_obra.after_or_equal' => 'A data de término deve ser posterior ou igual à data de início.',
            ]);
    
            $obra = Obra::findOrFail($id);
            $obra->update($validated);
    
            return redirect()->route('obra.index')->with('success', 'Obra atualizada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('obra.index')->with('error', 'Erro ao atualizar a obra: ' . $e->getMessage());
        }
    }
    
    
    

    public function destroy($id)
    {
        try {
            // Busca a obra pelo ID
            $obra = Obra::findOrFail($id);

            // Deleta a obra
            $obra->delete();

            // Redireciona com mensagem de sucesso
            return redirect()->route('obra.index')
                ->with('success', 'Obra deletada com sucesso!');
        } catch (\Exception $e) {
            // Redireciona com mensagem de erro
            return redirect()->route('obra.index')
                ->with('error', 'Não foi possível deletar a obra. Tente novamente.');
        }
    }
}
