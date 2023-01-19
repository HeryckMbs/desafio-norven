<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use App\Models\Manutencao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function getCarsbyBrand()
    {
        $myCars = Carro::where('dono_id', '=', Auth::id());
        dd($myCars);
    }

    public function servicos_manutencao($id_manutencao)
    {
        $manutencao = Manutencao::findOrFail($id_manutencao);
        dd($manutencao->servicos);
        try {
        } catch(\Exception $e) {
        }
    }
}
