@extends('layouts.app')
@section('title', 'Produtos da Categoria: ' . $categoria->nome)

@section('actions')

@endsection


@section('content')

    <table id="produtosCategoriaTable" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Produto</th>
                <th>Marca</th>
                <th>Fornecedor</th>
                <th>Criado por</th>

                <th class="d-flex justify-content-center">Informações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produtosCategoria as $produto)
                <tr>
                    <td>{{ $produto->id }}</td>
                    <td>{{ $produto->nome }}</td>
                    <td>{{ $produto->marca->nome }}</td>

                    <td>{{ $produto->fornecedor->nome }}</td>

                    <td>{{ $produto->responsavel->name }}</td>

                    <td class="d-flex  justify-content-center">
                        <button data-id="{{ $produto->id }}" type="button" class="btn btn-primary infoProduto">
                            <i class="fas fa-info"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Button trigger modal -->

    {{-- <td>{{ $produto->quantidadeEmEstoque }}</td>
    <td>{{ $produto->produtosEntraramEstoque->count()}}</td>
    <td>{{ $produto->produtosSairamEstoque->count()}}</td>
     --}}

    <!-- Modal -->
    <div class="modal fade" id="produtoModal" tabindex="-1" aria-labelledby="produtoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="produtoModalLabel">Informações do produto: <b><span
                                id="nomeProduto"></span></b>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formProduto" class="mb-2">
                        <div class="row">
                            <div class="col-2">
                                <label for="exampleInputEmail1" class="form-label">Código</label>
                                <input class="form-control" id="codigoProduto" disabled>
                            </div>
                            <div class="col-3">
                                <label for="exampleInputEmail1" class="form-label">Quantidade em estoque</label>
                                <input class="form-control" id="quantidadeEstoque" disabled>
                            </div>
                            <div class="col-3">
                                <label for="exampleInputEmail1" class="form-label">Quantidade de entradas</label>
                                <input class="form-control" id="qtdEntrada" disabled>
                            </div>

                            <div class="col-4">
                                <label for="exampleInputEmail1" class="form-label">Quantidade de Saídas</label>
                                <input class="form-control" id="qtdSaida" disabled>
                            </div>
                            <div class="col-3">
                                <label for="exampleInputEmail1" class="form-label">Unidade de Medida</label>
                                <input class="form-control" id="unidadeMedida" disabled>
                            </div>

                            <div class="col-4">
                                <label for="exampleInputEmail1" class="form-label">Fornecedor</label>
                                <input class="form-control" id="fornecedorNome" disabled>
                            </div>
                            <div class="col-5">
                                <label for="exampleInputEmail1" class="form-label">Marca</label>
                                <input class="form-control" id="marca" disabled>
                            </div>
                            <div class="col-6">
                                <label for="exampleInputEmail1" class="form-label">Data de cadastro</label>
                                <input class="form-control" id="dataCadastro" disabled>
                            </div>
                            <div class="col-6">
                                <label for="exampleInputEmail1" class="form-label">Responsável</label>
                                <input class="form-control" id="responsavel" disabled>
                            </div>
                            <div class="col-12 mt-1">
                                <div class="form-floating">
                                    <label for="floatingTextarea2">Descrição</label>
                                    <textarea class="form-control" id="descricaoProduto" disabled style="height: 100px;resize:none"></textarea>
                                </div>
                            </div>
                            <div class="col-12 mt-1">
                                <div class="row">
                                    <div class="col-3">
                                        <label for="exampleInputEmail1" class="form-label">Porção</label>
                                        <input disabled id="porcao" value="" class="form-control">
                                    </div>
            
                                    <div class="col-3">
                                        <label for="exampleInputEmail1" class="form-label">Proteína (g)</label>
                                        <input disabled id="proteina" value="" class="form-control">
                                    </div>
                                    <div class="col-3">
                                        <label for="exampleInputEmail1" class="form-label">Carboidratos (g)</label>
                                        <input disabled id="carboidrato" value="" class="form-control">
                                    </div>
                                    <div class="col-3">
                                        <label for="exampleInputEmail1" class="form-label">Gorduras Totais (g)</label>
                                        <input disabled id="gordura_total" value="" class="form-control">
                                    </div>
            
                                </div>
                            </div>


                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('.infoProduto').on('click', function() {
            console.log(this)
            fetch(`/api/produtoIndividual/${this.dataset.id}`).then(async (response) => {
                let result = await response.json();

                document.getElementById('nomeProduto').textContent = result.data.nome

                document.getElementById('codigoProduto').value = result.data.id
                document.getElementById('quantidadeEstoque').value = result.data.quantidadeEmEstoque
                document.getElementById('unidadeMedida').value = result.data.unidade_medida
                document.getElementById('qtdSaida').value = result.data.saidas
                document.getElementById('qtdEntrada').value = result.data.entradas

                document.getElementById('fornecedorNome').value = result.data.fornecedor.nome
                document.getElementById('marca').value = result.data.marca.nome
             
                let date = new Date(Date.parse(result.data.created_at));
                let dia = date.getDate().toString().padStart(2, '0');
                let mes = (date.getMonth() + 1).toString().padStart(2, '0');
                let ano = date.getFullYear();
                document.getElementById('dataCadastro').value = `${dia}/${mes}/${ano}`

                document.getElementById('responsavel').value = result.data.responsavel.name
                document.getElementById('descricaoProduto').value = result.data.descricao
          
                document.getElementById('porcao').value = result.data.informacao_nutricional.porcao
                document.getElementById('proteina').value = result.data.informacao_nutricional.proteina
                document.getElementById('carboidrato').value = result.data.informacao_nutricional.carboidrato
                document.getElementById('gordura_total').value = result.data.informacao_nutricional.gordura_total

                $('#produtoModal').modal('show')
            })

        })

        document.getElementById('produtoModal').addEventListener('hide.bs.modal', function() {
            document.getElementById('formProduto').reset()
        })
    </script>
@endpush
