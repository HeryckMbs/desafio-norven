<?php

namespace App\Http\Controllers;

use App\DataTables\ManutencaoDataTable;
use App\Models\Carro;
use App\Models\Manutencao;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ManutencaoController extends Controller
{
    public function index(ManutencaoDataTable $manutencaoDataTable)
    {
        $my_cars = Carro::where('dono_id', Auth::id())->get();
        return $manutencaoDataTable->render('manutencao.index', compact('my_cars'));
    }

    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make(
                $request->all(),
                [
                'carro' => 'required',
                'data_entrega' => 'required',
                'descricao' => 'required',

            ],
                [
                    'carro.required' => 'É necessário informar o veículo',
                    'data_entrega.required' => 'É necessário informar a data de entrega do veículo',
                    'descricao.required' => 'É necessário informar a descrição da manutenção',
                ]
            );
            if ($validator->fails()) {
                notify()->warning(implode(' ', $validator->messages()->all()), 'Atenção');
                return redirect(route('manutencao.index'), -1);
            }

            $dataManutencao = [
                'carro_id' => $request->carro,
                'data_entrega' => Carbon::parse($request->data_entrega),
                'servico_id' =>$request->servico,
                'descricao' => $request->descricao
            ];
            $novaManutencao = Manutencao::create($dataManutencao);

            dd($novaManutencao->carro);

            DB::commit();
            if ($novaManutencao) {
                notify()->success('Sua manutenção foi cadastrada com sucesso!.', 'EBA!');
                return redirect(route('manutencao.index'), );
            } else {
                notify()->error('Ocorreu um erro ao cadastrar sua manutenção, por favor tente novamente.', 'ERRO');
                return redirect(route('manutencao.index'), );
            }
        } catch(\Exception $e) {
            report($e);

            DB::rollBack();
            notify()->error($e->getMessage(), 'ERRO');
            return redirect(route('manutencao.index'), );
        }
    }
}
