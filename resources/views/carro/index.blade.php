@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="card ">
            <div class="card-header">
                <h5 class="card-title text-center">Meus Carros</h5>
                <div class="card-tools">
                    <button data-target="#modalRequest" data-toggle="modal" class="btn btn-form-ajax btn-primary">Adicionar
                        novo carro</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table table-responsive">
                    {{ $dataTable->table() }}

                </div>
            </div>
        </div>
    </div>

    <div id="modalRequest" class="modal fade">
        <div class="modal-dialog modal-default">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastrar Carro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>


                </div>


                <div class="modal-body">
                    <form method="POST" action="{{ route('carro.create') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Modelo</label>
                            <input type="text" class="form-control" id="ModeloCarro" name="modelo">

                        </div>
                        <div class="form-group">
                            <label>Cor</label>
                            <input type="Ano" class="form-control" name="cor">

                        </div>
                        <div class="form-group">
                            <label>Ano</label>
                            {{-- <select class="form-control" name="ano">
                                <option>SELECIONE UM ANO</option>
                                @for ($ano = 1920; $ano <= 2022; $ano++)
                                    <option value="{{ $ano }}">{{ $ano }}</option>
                                @endfor
                            </select> --}}
                        </div>
                        <div class="form-group">
                            <label for="Marca">Marca</label>
                            <select id="marca" class="form-control" name="marca">
                                <option>SELECIONE UM ANO</option>
                                @foreach ($marcas as $marca)
                                    <option value="{{ $marca->id }}">{{ $marca->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" id="newMarca" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Marca não encontrada?</label>
                        </div>
                        <div class="form-group ">
                            <label for="Modelo">Nova marca</label>
                            <input type="text" disabled class="form-control" id="Modelo" name="novaMarca">
                        </div>
                        <div class="form-group ">
                            <label for="Modelo">Descrição</label>
                            <textarea class="form-control" rows="3" name="descricao"></textarea>
                        </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>


            </div>


        </div>

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
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
