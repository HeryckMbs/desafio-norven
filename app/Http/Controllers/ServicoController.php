<?php

namespace App\Http\Controllers;

use App\DataTables\ServicoDataTable;
use App\Models\Carro;
use App\Models\Manutencao;
use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ServicoController extends Controller
{
    public function index(ServicoDataTable $servicoDataTable)
    {
        return $servicoDataTable->render('servico.index');
    }

    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'nome' => 'required',
                'valor' => 'required',
            ], [
                'nome.required' => 'É necessário informar o nome do serviço',
                'valor.required' => 'É necessário informar o valor do serviço',
            ]);

            if ($validator->fails()) {
                notify()->warning(implode(' ', $validator->messages()->all()), 'Atenção');
                return redirect(route('servico.index'), );
            }
            $data_servico = [
                'nome' => $request->nome,
                'valor' => $request->valor,
                'descricao' => $request->descricao == null ? '' : $request->descricao,
                'url_foto' => isset($request->url_foto) ? $request->url_foto : ''
            ];

            Servico::create($data_servico);
            DB::commit();
            notify()->success('Serviço cadastrado com sucesso', 'Eba!');
            return redirect(route('servico.index'));
        } catch(\Exception $e) {
            report($e);
            DB::rollBack();
            notify()->error($e->getMessage(), 'ERRO');
            return redirect(route('servico.index'), );
        }
    }


    public function servicos_manutencao($id_manutencao)
    {
        try {
            $manutencao = Manutencao::findOrFail($id_manutencao);
            return $manutencao->servicos();
        } catch(\Exception $e) {
            notify()->error($e->getMessage(), 'ERRO');
            return redirect(route('servico.index'), );
        }
    }

    public function form($idServico)
    {
        $servico = Servico::findOrFail($idServico);
        return view('servico.form',compact('servico'));
    }

    public function update(Request $request, $idServico){
        $validator = Validator::make(
            $request->all(),
            [
                'nome' => 'required',
                'valor' => 'required',
            ],
            [
                'nome.required' => 'É necessário informar o nome do serviço',
                'valor.required' => 'É necessário informar o valor do serviço',
            ]
        );
        if ($validator->fails()) {
            notify()->warning(implode(' ', $validator->messages()->all()), 'Atenção');
            return redirect(route('carro.index'), 302);
        }

        $servico = Servico::findOrFail($idServico);
        $data = [
            'valor' => $request->valor,
            'url_foto' => $request->url_foto,
            'descricao' => $request->descricao,
            'nome' => $request->nome,
        ];
        try {
            DB::beginTransaction();
            $servico->update($data);
            DB::commit();
            notify()->success('Seu serviço foi atualizado com sucesso!.', 'EBA!');
            return redirect(route('servico.index'),);
        } catch (\Exception $e) {
            report($e);
            notify()->error($e->getMessage(), 'ERRO');
            return redirect(route('servico.index'),);
        }
    }

    public function delete($idCarro)
    {
        try {
            $servico = Servico::findOrFail($idCarro);
            DB::beginTransaction();
            $servico->delete();
            DB::commit();
            notify()->success('Seu serviço foi excluído com sucesso!', 'EBA!');
            return redirect(route('servico.index'), );
        } catch(\Exception $e) {
            DB::rollBack();
            notify()->error($e->getMessage(), 'ERRO');
            return redirect(route('servico.index'), );
        }
    }

}
