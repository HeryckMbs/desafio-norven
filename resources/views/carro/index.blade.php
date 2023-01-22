@extends('layouts.app')
@section('title', 'Meus carros')
@section('actions')
    <button data-target="#modalRequest" data-toggle="modal" class="btn btn-primary">Adicionar
        novo carro</button>
    <button data-target="#modalRequest" data-toggle="modal" class="btn btn-primary">Adicionar nova Marca</button>
@endsection
@section('content')

    <div class="row">
        <div class="col-md-4">
            <div class="info-box bg-success">
                <span class="info-box-icon"><i class="fa fa-car"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Quantidade de Carros</span>
                    <span class="info-box-number">{{ $qtd_carros }}</span>
                </div>
              </div>
        </div>
        <div class="col-md-4">
            <div class="info-box bg-success">
                <span class="info-box-icon"><i class="fa fa-heart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Marca mais Famosa</span>
                    <span class="info-box-number">{{isset($marcaMaisFamosa) && !empty($marcaMaisFamosa) ? $marcaMaisFamosa->nome : 'Nenhuma'}}</span>
                </div>
              </div>
        </div>
        <div class="col-md-4">
            <div class="info-box bg-success">
                <span class="info-box-icon"><i class="fa fa-heart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Marca mais Famosa</span>
                    <span class="info-box-number">{{isset($marcaMaisFamosa) && !empty($marcaMaisFamosa) ? $marcaMaisFamosa->nome : 'Nenhuma'}}</span>
                </div>
              </div>
        </div>
    </div>
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
