<?php

namespace App\Http\Controllers;

use App\Models\Manutencao;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function manutencoesPorMes()
    {
        $minhasManutencoes = Manutencao::where('cliente_id', '=', Auth::id())->get();
        $meses = [
            '01' => 0,
            '02' => 0,
            '03' => 0,
            '04' => 0,
            '05' => 0,
            '06' => 0,
            '07' => 0,
            '08' => 0,
            '09' => 0,
            '10' => 0,
            '11' => 0,
            '12' => 0,
            'count' => 0
        ];
        foreach ($minhasManutencoes as $manutencoes) {
            if ($manutencoes->created_at->format('Y') == Carbon::now()->format('Y')) {
                $meses[$manutencoes->created_at->format('m')] += 1;
            }
        }
        $meses['count'] = count($meses) - 1;
        return $meses;
    }
}
