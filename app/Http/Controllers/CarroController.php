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
        $meusCarros = Carro::where('responsavel_id', Auth::id())->get();
        $qtd_carros = count($meusCarros);
        $marcasMyCars = DB::table('carros')
            ->join('marcas', 'marcas.id', '=', 'carros.marca_id')
            ->where('carros.responsavel_id','=',Auth::id())
            ->selectRaw('marcas.nome, count(carros.marca_id)')
            ->groupBy('marcas.nome')
            ->get();
        $maior = 0;
        $marcaMaisFamosa = [];
        foreach ($marcasMyCars as $marca) {
            if($marca->count > $maior){
                $maior= $marca->count;
                $marcaMaisFamosa = $marca;
            }
        }
        return $carrosDataTable->render('carro.index', compact('marcas', 'qtd_carros','marcaMaisFamosa'));
    }

    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
            'cor' => 'required',
            'modelo' => 'required',
            'descricao' => 'required',
            'ano' => 'required',
            'placa' => 'required',
            'kilometragem' => 'required'
        ],
            [
                'cor.required' => 'É necessário informar a cor do veículo',
                'modelo.required' => 'É necessário informar o modelo do veículo',
                'descricao.required' => 'É necessário informar a descrição do veículo',
                'ano.required' => 'É necessário informar o ano de fabricação do veículo',
                'placa.required' => 'É necessário informar a placa do veículo',
                'kilometragem.required' => 'É necessário informar a kilometragem do veículo'
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
                'responsavel_id' => Auth::id(),
                'placa' => $request->placa,
                'kilometragem' => $request->kilometragem
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
            'placa' => 'required',
            'kilometragem' => 'required'
        ],
            [
                'cor.required' => 'É necessário informar a cor do veículo',
                'modelo.required' => 'É necessário informar o modelo do veículo',
                'descricao.required' => 'É necessário informar a descrição do veículo',
                'ano.required' => 'É necessário informar o ano de fabricação do veículo',
                'placa.required' => 'É necessário informar a placa do veículo',
                'kilometragem.required' => 'É necessário informar a kilometragem do veículo'
            ]
        );
        if ($validator->fails()) {
            notify()->warning(implode(' ', $validator->messages()->all()), 'Atenção');
            return redirect(route('carro.index'), 302);
        }


        try {
            $carro = Carro::findOrFail($idCarro);
            $data =  [
                'modelo' => $request->modelo,
                'cor' => $request->cor,
                'ano' => $request->ano,
                'marca_id' => isset($novaMarca) ? $novaMarca->id : $request->marca,
                'descricao' => $request->descricao,
                'responsavel_id' => Auth::id(),
                'placa' => $request->placa,
                'kilometragem' => $request->kilometragem
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
