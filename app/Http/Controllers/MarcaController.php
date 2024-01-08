<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaRequest;
use App\Models\Marca;
use App\Repositories\MarcaRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    private MarcaRepository $marcaRepository;

    public function __construct(MarcaRepository $marcaRepository){
        $this->marcaRepository = $marcaRepository;
    }
    public function index(): View|RedirectResponse
    {
        try {
            $marcas = $this->marcaRepository->getIndex();
            return view('marca.index', compact('marcas'));
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível acessar o menu->withInput($request->all()); marca!']]);
        }

    }

    public function create(): View|RedirectResponse
    {
        try {
            return view('marca.form');
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível acessar o cadastro marca!']]);
        }
    }

    public function store(MarcaRequest $request): RedirectResponse
    {
        try {
            $this->marcaRepository->store($request);
            return redirect(route('marca.index'))->with('messages', ['success' => ['Marca criada com sucesso!']]);
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível salvar a marca!']])->withInput($request->all());;
        }
    }

    public function show($id)
    {
    }

    public function edit(int $id) : View|RedirectResponse
    {
        try {
            $marca = Marca::findOrFail($id);
            return view('marca.form', compact('marca'));
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível encontrar a marca!']]);
        }
    }

    public function update(MarcaRequest $request, int $id) : RedirectResponse
    {
        try {
            $this->marcaRepository->update($request,$id);
            return redirect(route('marca.index'))->with('messages', ['success' => ['Marca atualizada com sucesso!']]);
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível atualizar a marca!']])->withInput($request->all());;
        }
    }

    public function destroy(int $id) : RedirectResponse
    {
        try {
            $this->marcaRepository->destroy($id);
            return back()->with('messages', ['success' => ['Marca excluída com sucesso!']]);
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível excluir a marca!']]);
        }
    }
}
