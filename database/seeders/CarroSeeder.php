<?php

namespace Database\Seeders;

use App\Models\Carro;
use App\Models\Marca;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class CarroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vw = Marca::where(['nome' =>'Volkswagen'])->first();
        $gol = Carro::create([
            'cor' => 'Verde',
            'modelo' => 'Gol 1000',
            'marca_id' => 1,
            'dono_id' => 1,
            'descricao' => 'Carro lendário que está há 20 anos na familia',
            'ano' => 1995
        ]);
        // dd($gol);
    }
}
