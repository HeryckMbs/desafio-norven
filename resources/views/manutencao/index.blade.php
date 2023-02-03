@extends('layouts.app')
@section('title', 'Minhas manutenções')
@section('actions')
    <button data-target="#modalRequest" data-toggle="modal" class="btn btn-primary">Adicionar
        nova manutenção</button>

@endsection
@section('content')
    <div class="table table-responsive">
        {{ $dataTable->table() }}
    </div>


    <div id="modalRequest" class="modal fade" aria-hidden="true">
        @include('manutencao.form')
    </div>

    <div id="modalServicos" class="modal fade" aria-hidden="true">
        @include('manutencao.servicos')
    </div>
    <script>

    </script>
@endsection



@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
