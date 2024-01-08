<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaRequest;
use App\Models\Marca;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function index(): View
    {
        $marcas = Marca::index();
        return view('marca.index', compact('marcas'));
    }

    public function create(): View
    {
        return view('marca.form');
    }

    public function store(MarcaRequest $request): RedirectResponse
    {
        try {
            Marca::create($request->except('_token'));
            return redirect(route('marca.index'))->with('messages', ['success' => ['Marca criada com sucesso!']]);
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível salvar a marca!']]);

        }
    }

    public function show($id)
    {
    }

    public function edit($id) : View|RedirectResponse
    {
        try {
            $marca = Marca::findOrFail($id);
            return view('marca.form', compact('marca'));
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível encontrar a marca!']]);
        }
    }

    public function update(MarcaRequest $request, $id) : RedirectResponse
    {
        try {
            Marca::findOrFail($id)->update($request->except(['_token', '_method']));
            return redirect(route('marca.index'))->with('messages', ['success' => ['Marca atualizada com sucesso!']]);
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível atualizar a marca!']]);
        }
    }

    public function destroy($id) : RedirectResponse
    {
        try {
            Marca::findOrFail($id)->delete();
            return back()->with('messages', ['success' => ['Marca excluída com sucesso!']]);
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível excluir a marca!']]);
        }
    }
}
