@extends('layouts.app')
@section('title', 'Clientes')
@section('actions')
    <button data-target="#modalRequest" data-toggle="modal" class="btn btn-primary">Adicionar
        novo Cliente</button>

@endsection

@section('content')
<div id="modalRequest" class="modal fade" aria-hidden="true">
    @include('clientes.form')
</div>
@endsection



@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    {{-- {{ $dataTable->scripts(attributes: ['type' => 'module']) }} --}}
@endpush
