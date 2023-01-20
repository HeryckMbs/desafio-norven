@extends('layouts.app')

@section('content')
    <!-- Main content -->

    <div class="row">
        <div class="col-6">
            <label>Manutenções por Mês</label>

            <canvas id="myChart" aria-label="Hello ARIA World">
            </canvas>
        </div>
        <div class="col-6">
            <label>Meus Agendamentos</label>

            <div class="table table-responsive">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>


    <!-- /.content -->
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
