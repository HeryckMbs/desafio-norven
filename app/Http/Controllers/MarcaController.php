<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaRequest;
use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function index()
    {
        $marcas = Marca::index();
        return view('marca.index', compact('marcas'));
    }

    public function create()
    {
        return view('marca.form');
    }

    public function store(MarcaRequest $request)
    {
        Marca::create($request->except('_token'));
        return redirect(route('marca.index'))->with('messages', ['success' => ['Marca criada com sucesso!']]);
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        try {
            $marca = Marca::findOrFail($id);
            return view('marca.form', compact('marca'));
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível encontrar a marca!']]);
        }
    }

    public function update(MarcaRequest $request, $id)
    {
        try {
            Marca::findOrFail($id)->update($request->except(['_token', '_method']));
            return redirect(route('marca.index'))->with('messages', ['success' => ['Marca atualizada com sucesso!']]);
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível atualizar a marca!']]);
        }
    }

    public function destroy($id)
    {
        try {
            Marca::findOrFail($id)->delete();
            return back()->with('messages', ['success' => ['Marca excluída com sucesso!']]);
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível excluir a marca!']]);
        }
    }
}
