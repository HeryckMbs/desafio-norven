<?php

namespace App\Http\Controllers;

use App\DataTables\ServicoDataTable;
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
        }
    }
}
