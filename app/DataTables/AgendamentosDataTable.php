<?php

namespace App\DataTables;

use App\Models\Agendamento;
use App\Models\Categoria;
use App\Models\Manutencao;
use App\Models\Servico;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AgendamentosDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return (new EloquentDataTable($query))
        ->editColumn('status', function($s){
            return strtoupper($s->status);
        })
        ->editColumn('data_entrega', function ($r) {
            return Carbon::parse($r->data_entrega)->format('d/m/Y');
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Categoria $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Categoria $model)
    {
        return $model->newQuery()
        ->join('carros', 'carros.id', '=', 'manutencaos.carro_id')
        ->where('carros.responsavel_id', '=', Auth::id())
        ->where('data_entrega', '<=', Carbon::now()->addDays(7));
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('agendamentos-table')
            ->columns($this->getColumns())
            ->responsive(true)
            ->searching(false)
            ->scrollCollapse(true)
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->buttons([
            ])
            ->orderBy(1)
            ->selectStyleSingle();
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('modelo')->title('Carro'),
            Column::make('data_entrega')->title('Data de Entrega'),
            Column::make('status')->title('Status'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Agendamentos_' . date('YmdHis');
    }
}
