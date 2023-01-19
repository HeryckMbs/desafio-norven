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
        function getServicos(id_manutencao) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#servicos').empty();
            $.ajax({
                method: "GET",
                url: `/servicos_manutencao/${id_manutencao}`

            }).done(function(response) {
                console.log(response)
                response.forEach(function(element) {
                    let html = `<div class="card" >
                                    <img class="card-img-top"
                                    src="https://img.freepik.com/fotos-gratis/trabalhador-de-servico-de-carro-muscular-reparando-o-veiculo_146671-19605.jpg?w=2000"
                                    alt="Card image cap">
                                    <div class="card-body">
                                        <h3 class="card-title" style="font-weight: bold;">${element.nome}</h3>
                                        <p class="card-text">Descrição: ${element.descricao}</p>
                                        <p class="card-text">Valor: R$ ${element.valor}</p>
                                        <p class="card-text">Desconto: ${element.valor}%</p>
                                    </div>
                                </div>`
                    $('#servicos').append(html)
                })
            })
        }
    </script>
@endsection



@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
