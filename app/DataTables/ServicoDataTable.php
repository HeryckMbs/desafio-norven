<?php

namespace App\DataTables;

use App\Models\Servico;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ServicoDataTable extends DataTable
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
            ->addColumn('action', 'servico.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Servico $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Servico $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('servico-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons([
                        Button::make('print')->text('<i class="fa fa-print"></i>'),
                        Button::make('reset')->text('<i class="fa fa-sync"></i>'),
                    ]);
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
            Column::make('nome', )->title('Nome'),
            Column::make('descricao')->title('Descrição'),
            Column::make('valor')->title('Valor'),
            Column::make('desconto')->title('Desconto'),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Servico_' . date('dmY');
    }
}
