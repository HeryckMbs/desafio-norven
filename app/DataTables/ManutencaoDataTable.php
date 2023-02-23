<?php

namespace App\DataTables;

use App\Models\Carro;
use App\Models\Manutencao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Carbon\Carbon;

use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ManutencaoDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return (new EloquentDataTable($query->with(['carro'])))
        ->editColumn('created_at', function ($r) {
            return Carbon::parse($r->created_at)->format('d/m/Y');
        })
        ->addColumn('action', 'manutencao.action')
        ->rawColumns(['link', 'action'])
        ->editColumn('status', function ($r) {
            return strtoupper($r->status);
        })
            ->editColumn('valor', function ($r){
                return 'R$ ' . number_format($r->valor,2,',','.');
            })
        ->editColumn('data_entrega', function ($r) {
            return Carbon::parse($r->data_entrega)->format('d/m/Y');
        });

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Manutencao $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Manutencao $model)
    {
        $my_cars = DB::table('carros')
        ->where('responsavel_id', '=', Auth::id())
        ->select('id')->pluck('id')->toArray();

        return $model->newQuery()->whereIn('carro_id', $my_cars);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('manutencao-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->responsive(true)
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('print')->text('<i class="fa fa-print"></i>'),
                        Button::make('reset')->text('<i class="fa fa-sync"></i>'),
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [

                  Column::make('id')->title('#'),
                  Column::make('descricao')->title('Descrição'),
                  Column::make('valor')->title('Valor'),
                  Column::make('status')->title('Status'),
                  Column::make('carro.modelo')->title('Carro'),
                  Column::make('data_entrega')->title('Data de entrega'),
                  Column::make('created_at')->title('Criado em'),
                  Column::computed('action')->title('Ações')
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Carros_' . date('dmY');
    }
}
