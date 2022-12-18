@extends('layouts.app')
@section('title', 'Meus carros')
@section('actions')
    <button data-target="#modalRequest" data-toggle="modal" class="btn btn-primary">Adicionar
        novo carro</button>
@endsection
@section('content')
    <div class="table table-responsive">
        {{ $dataTable->table() }}
    </div>


    <div id="modalRequest" class="modal fade" aria-hidden="true">
        @include('carro.form')
    </div>

    <script>
        $('#newMarca').on('click', function() {
            let confirm = $('#newMarca').is(":checked")
            if (confirm) {
                console.log('safksd')
                $('#marca').val('')
                $('#marca').prop('disabled', true)
                $('#Modelo').prop('disabled', false)
            } else {
                $('#marca').prop('disabled', false)
                $('#Modelo').prop('disabled', true)
            }
        })
    </script>
@endsection



@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
