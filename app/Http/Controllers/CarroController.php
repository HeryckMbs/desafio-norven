<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use App\DataTables\CarrosDataTable;
use App\Models\Carro;
use App\Models\Marca;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CarroController extends Controller
{
    public function index(CarrosDataTable $carrosDataTable, Carro $model)
    {
        $marcas = Marca::get();
        return $carrosDataTable->render('carro.index', compact('marcas'));
    }

    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
            'cor' => 'required',
            'modelo' => 'required',
            'descricao' => 'required',
            'ano' => 'required'
        ],
            [
                'cor.required' => 'É necessário informar a cor do veículo',
                'modelo.required' => 'É necessário informar o modelo do veículo',
                'descricao.required' => 'É necessário informar a descrição do veículo',
                'ano.required' => 'É necessário informar o ano de fabricação do veículo'
            ]
        );
        if ($validator->fails()) {
            notify()->warning(implode(' ', $validator->messages()->all()), 'Atenção');
            return redirect(route('carro.index'), 302);
        }
        try {
            DB::beginTransaction();

            if (isset($request->newMarca) && $request->newMarca == 'on') {
                $novaMarca = Marca::create(['nome' => $request->marca]);
            }

            $data_carro = [
                'modelo' => $request->modelo,
                'cor' => $request->cor,
                'ano' => $request->ano,
                'marca_id' => isset($novaMarca) ? $novaMarca->id : $request->marca,
                'descricao' => $request->descricao,
                'dono_id' => Auth::id()
            ];
            $newCarro = Carro::create($data_carro);
            DB::commit();
            if ($newCarro) {
                notify()->success('Seu veículo foi cadastrado com sucesso!.', 'EBA!');
                return redirect(route('carro.index'), );
            } else {
                notify()->error('Ocorreu um erro ao cadastrar seu veículo, por favor tente novamente.', 'ERRO');
                return redirect(route('carro.index'), );
            }
        } catch(\Exception $e) {
            report($e);
            DB::rollBack();
            notify()->error($e->getMessage(), 'ERRO');
            return redirect(route('carro.index'), );
        }
    }

    public function delete($idCarro)
    {
        try {
            $carro = Carro::findOrFail($idCarro);
            DB::beginTransaction();
            $carro->delete();
            DB::commit();
            notify()->success('Seu veículo foi excluído com sucesso!', 'EBA!');
            return redirect(route('carro.index'), );
        } catch(\Exception $e) {
            DB::rollBack();
            notify()->error($e->getMessage(), 'ERRO');
            return redirect(route('carro.index'), );
        }
    }

    public function form($idCarro)
    {
        $marcas = Marca::get();
        $carro = Carro::findOrFail($idCarro);
        return view('carro.form', compact('marcas', 'carro'));
    }

    public function update(Request $request, $idCarro)
    {
        $validator = Validator::make(
            $request->all(),
            [
            'cor' => 'required',
            'modelo' => 'required',
            'descricao' => 'required',
            'ano' => 'required',
            'marca' => 'required'
        ],
            [
                'cor.required' => 'É necessário informar a cor do veículo',
                'modelo.required' => 'É necessário informar o modelo do veículo',
                'descricao.required' => 'É necessário informar a descrição do veículo',
                'ano.required' => 'É necessário informar o ano de fabricação do veículo',
                'marca.required' => 'É necessário informar a marca do veículo'

            ]
        );
        if ($validator->fails()) {
            notify()->warning(implode(' ', $validator->messages()->all()), 'Atenção');
            return redirect(route('carro.index'), 302);
        }


        try {
            $carro = Carro::findOrFail($idCarro);
            $data = [
                'modelo' => $request->modelo,
                'cor' => $request->cor,
                'ano' => $request->ano,
                'marca_id' => $request->marca,
                'descricao' => $request->descricao
            ];
            DB::beginTransaction();
            $carro->update($data);
            DB::commit();
            notify()->success('Seu veículo foi atualizado com sucesso!.', 'EBA!');
            return redirect(route('carro.index'), );
        } catch(\Exception $e) {
            report($e);
            notify()->error($e->getMessage(), 'ERRO');
            return redirect(route('carro.index'), );
        }
    }
}
