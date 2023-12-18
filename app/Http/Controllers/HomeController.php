<?php

namespace App\Http\Controllers;

use App\DataTables\AgendamentosDataTable;
use App\Models\Categoria;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index( )
    {
        $categorias = Categoria::all();
        return view('home', compact('categorias'));
    }
}
