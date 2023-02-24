<?php

namespace App\Http\Controllers;

use App\DataTables\ManutencaoDataTable;
use App\Models\Carro;
use App\Models\Manutencao;
use App\Models\Marca;
use App\Models\Servico;
use App\Models\ServicosManutencoes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class  ManutencaoController extends Controller
{
    public function index(ManutencaoDataTable $manutencaoDataTable)
    {
        $my_cars = Carro::where('responsavel_id', Auth::id())->get();
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
                return redirect(route('manutencao.index'), 302);
            }
            $carro = Carro::findOrFail($request->carro);
            $valor = substr($request->valor, 4);
            $valor = str_replace('.', '', $valor);
            $valor = str_replace(',', '.', $valor);
            $dataManutencao = [
                'carro_id' => $carro->id,
                'data_entrega' => Carbon::parse($request->data_entrega),
                'status' => $request->status,
                'valor' => (float)$valor,
                'descricao' => $request->descricao,
                'cliente_id' => $carro->responsavel_id
            ];
            $novaManutencao = Manutencao::create($dataManutencao);

            if (isset($request->servico) && $request->servico != null) {
                foreach ($request->servico as $servico) {
                    ServicosManutencoes::create(['manutencao_id' => $novaManutencao->id, 'servico_id' => $servico]);
                }
            }

            DB::commit();
            notify()->success('Sua manutenção foi cadastrada com sucesso!.', 'EBA!');
            return redirect(route('manutencao.index'),);

        } catch (\Exception $e) {
            report($e);
            DB::rollBack();
            notify()->error('Ocorreu um erro ao cadastrar sua manutenção, por favor tente novamente.', 'ERRO');
            return redirect(route('manutencao.index'),);
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
            return redirect(route('manutencao.index'),);
        } catch (\Exception $e) {
            report($e);
            DB::rollBack();
            notify()->success('Não foi possível excluir sua manutenção, por favor tente novamente!', 'Erro!');
            return redirect(route('manutencao.index'),);
        }
    }


    public function searchManutencao($id)
    {

        $manutencao = Manutencao::findOrFail($id)->with(['carro'])->first();
        return [$manutencao, $manutencao->servicos()];
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'carro' => 'required',
                'valor' => 'required',
                'data_entrega' => 'required'
            ],
            [
                'carro.required' => 'É necessário informar o veículo',
                'valor.required' => 'É necessário pelo menos um serviço para a manutenção',
                'data_entrega.required' => 'É necessário informar quando a manutenção será entregue'
            ]
        );
        if ($validator->fails()) {
            notify()->warning(implode(' ', $validator->messages()->all()), 'Atenção');
            return redirect(route('manutencao.index'), 302);
        }
        try {
            $manutencao = Manutencao::findOrFail($id);
            $valor = substr($request->valor, 4);
            $valor = str_replace('.', '', $valor);
            $valor = str_replace(',', '.', $valor);
            $manutencao_data = [
                'data_entrega' => Carbon::parse($request->data_entrega),
                'status' => $request->status,
                'descricao' => $request->descricao,
                'valor' => $valor,
            ];
            if (isset($request->servico) && $request->servico != null) {
                DB::table('servicos_manutencoes')->where('manutencao_id','=',$manutencao->id)->delete();
                foreach ($request->servico as $servico) {
                    ServicosManutencoes::create(['manutencao_id' => $manutencao->id, 'servico_id' => $servico]);
                }
            }
            $manutencao->update($manutencao_data);
            notify()->success('Sua manutenção foi atualizada com sucesso!', 'EBA!');
            return redirect(route('manutencao.index'),);
        } catch (\Exception $e) {
            report($e);
            DB::rollBack();
            notify()->success('Não foi possível atualizar sua manutenção, por favor tente novamente! '. $e->getMessage(), 'Erro!');
            return redirect(route('manutencao.index'),);
        }
    }

    public function form($idmanutencao)
    {
        $manutencao = Manutencao::findOrFail($idmanutencao);
        $my_cars = Carro::where('responsavel_id', Auth::id())->get();
        $servicos = Servico::get();
        $manutencao_servicos = $manutencao->servicos();
        return view('manutencao.form', compact('manutencao', 'my_cars', 'servicos', 'manutencao_servicos'));
    }
}
