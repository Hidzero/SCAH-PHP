<?php

// app/Http/Controllers/ManualController.php
namespace App\Http\Controllers;

use App\Models\Manual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManualController extends Controller
{
    public function index()
    {
        $manuais = Manual::with('uploader')->orderByDesc('created_at')->get();
        return view('manutencao.indexManuais', compact('manuais'));
    }

    public function create()
    {
        return view('manutencao.createManuais');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'arquivo' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:5120',
        ]);

        $path = $request->file('arquivo')->store('manuais', 'public');

        Manual::create([
            'original_name' => $request->file('arquivo')->getClientOriginalName(),
            'file_path'     => $path,
            'user_id'       => auth()->id(),
        ]);

        return redirect()->route('manutencao.manuais.index')->with('success', 'Manual enviado com sucesso.');
    }

    public function download(Manual $manual)
    {
        return Storage::disk('public')->download($manual->file_path, $manual->original_name);
    }

    public function destroy(Manual $manual)
    {
        Storage::disk('public')->delete($manual->file_path);
        $manual->delete();
        return back()->with('success', 'Manual excluído.');
    }
}
