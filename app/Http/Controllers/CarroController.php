<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use App\DataTables\CarrosDataTable;
use App\Models\Carro;
use App\Models\Marca;
use Illuminate\Support\Facades\Validator;

class CarroController extends Controller
{
    public function index(CarrosDataTable $carrosDataTable, Carro $model)
    {
        $marcas = Marca::get();
        toastr()->warning('Are you sure you want to proceed ?');
        return $carrosDataTable->render('carro.index', compact('marcas'));
    }

    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'cor' => 'required',
                'modelo' => 'required',
                'descricao' => 'required',
                'ano' => 'required'
            ]);

            if ($validator->fails()) {
            }
        } catch(\Exception $e) {
        }
    }
}
