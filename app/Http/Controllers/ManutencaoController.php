<?php

namespace App\Http\Controllers;

use App\DataTables\ManutencaoDataTable;
use App\Models\Carro;
use App\Models\Manutencao;
use App\Models\Servico;
use App\Models\ServicosManutencoes;
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
        $servicos = Servico::get();
        return $manutencaoDataTable->render('manutencao.index', compact('my_cars', 'servicos'));
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
                'status' =>$request->status,
                'descricao' => $request->descricao
            ];
            $novaManutencao = Manutencao::create($dataManutencao);

            foreach ($request->servico as $servico) {
                ServicosManutencoes::create(['manutencao_id' => $novaManutencao->id, 'servico_id' => $servico]);
            }


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

    public function delete($id)
    {
        try {
            $manutencao = Manutencao::findOrFail($id);
            DB::beginTransaction();
            $manutencao->delete();
            DB::commit();
            notify()->success('Sua manutenção foi excluída com sucesso!.', 'EBA!');
            return redirect(route('manutencao.index'), );
        } catch(\Exception $e) {
            report($e);
            DB::rollBack();
            notify()->success('Não foi possível excluir sua manutenção, por favor tente novamente!', 'Erro!');
            return redirect(route('manutencao.index'), );
        }
    }


    public function searchManutencao($id)
    {
        $manutencao = Manutencao::findOrFail($id)->with(['carro'])->first();
        return $manutencao;
    }

    public function update(Request $request, $id)
    {
        try {
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
                return redirect(route('manutencao.index'), 302);
            }
            $manutencao = Manutencao::findOrFail($id);
            $manutencao_data = [
                'carro_id' => $request->carro,
                'data_entrega' => Carbon::parse($request->data_entrega),
                'status' =>$request->status,
                'descricao' => $request->descricao
            ];
            $manutencao->update($manutencao_data);
            notify()->success('Sua manutenção foi atualizada com sucesso!', 'EBA!');
            return redirect(route('manutencao.index'), );
        } catch(\Exception $e) {
            report($e);
            DB::rollBack();
            notify()->success('Não foi possível atualizar sua manutenção, por favor tente novamente!', 'Erro!');
            return redirect(route('manutencao.index'), );
        }
    }
}
