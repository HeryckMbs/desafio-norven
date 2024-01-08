<?php

use App\Enums\TipoLancamento;
use App\Http\Requests\LancamentoRequest;
use App\Models\Lancamento;
use App\Models\Lote;
use Illuminate\Support\Facades\Auth;

class LancamentoRepository{
    private Lancamento $lancamento;

    public function __construct(Lancamento $lancamento){
        $this->lancamento = $lancamento;
    }

    public function getIndex(){
        try {
            return $this->lancamento->index();
        } catch (\Exception $e) {
            throw $e;
        }
        
    }

    public function saida(int $lote_id,int $quantidade){
        try {
            Lancamento::create([
                'tipo' => TipoLancamento::Saida,
                'lote_id' => $lote_id,
                'quantidade' => $quantidade,
                'created_by' => Auth::id()
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function entrada(int $lote_id,int $quantidade){
   
        try {
            Lancamento::create([
                'tipo' => TipoLancamento::Entrada,
                'quantidade' => $quantidade,
                'lote_id' => $lote_id,
                'created_by' => Auth::id()
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}