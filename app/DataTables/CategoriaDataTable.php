<?php

namespace App\DataTables;

use App\Models\Categoria;
use App\Models\Categorium;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CategoriaDataTable extends DataTable
{
    public function dataTable($query)
    {
        return (new EloquentDataTable($query->with(['produtosEmEstoque'])));
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Categoria $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Categoria $model)
    {

        return $model->newQuery()->where('id','=',$this->categoria_id)->produtosEmEstoque;
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
                    ->responsive(true)
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
   
        
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'ProdutoCategoria_' . date('dmY');
    }
}
