@extends('layouts.app')
@section('title', 'Produtos da Categoria: ' . $categoria->nome)

@section('actions')

@endsection


@section('content')

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Produto</th>
                <th>Código</th>
                <th>Data de Validade</th>
                <th>Lote</th>
                <th>Responsável</th>
                <th>Quantidade em estoque</th>
                <th class="d-flex justify-content-center">Informações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produtosCategoria as $produtoEmEstoque)
                <tr>
                    <td>{{ $produtoEmEstoque->id }}</td>
                    <td>{{ $produtoEmEstoque->produto->nome }}</td>
                    <td>{{ $produtoEmEstoque->produto->codigo }}</td>
                    <td>{{ \Carbon\Carbon::parse($produtoEmEstoque->produto->data_validade)->format('d/m/Y') }}</td>
                    <td>{{ $produtoEmEstoque->produto->lote }}</td>
                    <td>{{ $produtoEmEstoque->produto->responsavel->name }}</td>
                    <td>{{ $produtoEmEstoque->produto->produtosEmEstoque->count() }}</td>
                    <td class="d-flex  justify-content-center">
                        <button data-id="{{ $produtoEmEstoque->produto_id }}" type="button"
                            class="btn btn-primary infoProduto">
                            <i class="fas fa-info"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Button trigger modal -->


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
                    <form id="formProduto">
                    <div class="row">
                            <div class="col-6">
                                <label for="exampleInputEmail1" class="form-label">Código do Produto</label>
                                <input class="form-control" id="codigoProduto" disabled>
                            </div>
                            <div class="col-3">
                                <label for="exampleInputEmail1" class="form-label">Quantidade em estoque</label>
                                <input class="form-control" id="quantidadeEstoque" disabled>
                            </div>
                            <div class="col-3">
                                <label for="exampleInputEmail1" class="form-label">Unidade de Medida</label>
                                <input class="form-control" id="unidadeMedida" disabled>
                            </div>
    
                            <div class="col-3">
                                <label for="exampleInputEmail1" class="form-label">Preço de custo</label>
                                <input class="form-control" id="precoCusto" disabled>
                            </div>
                            <div class="col-3">
                                <label for="exampleInputEmail1" class="form-label">Preço de Venda</label>
                                <input class="form-control" id="precoVenda" disabled>
                            </div>
    
                            <div class="col-6">
                                <label for="exampleInputEmail1" class="form-label">Fornecedor</label>
                                <input class="form-control" id="fornecedorNome" disabled>
                            </div>
                            <div class="col-6">
                                <label for="exampleInputEmail1" class="form-label">Marca</label>
                                <input class="form-control" id="marca" disabled>
                            </div>
                            <div class="col-6">
                                <label for="exampleInputEmail1" class="form-label">Data de cadastro</label>
                                <input class="form-control" id="dataCadastro" disabled>
                            </div>
                            <div class="col-12">
                                <label for="exampleInputEmail1" class="form-label">Responsável</label>
                                <input class="form-control" id="responsavel" disabled>
                            </div>
                            <div class="col-6 mt-1">
                                <div class="form-floating">
                                    <label for="floatingTextarea2">Descrição</label>
                                    <textarea class="form-control" id="descricaoProduto" disabled style="height: 100px;resize:none"></textarea>
                                </div>
                            </div>
                            <div class="col-6 mt-1">
                                <div class="form-floating">
                                    <label for="floatingTextarea2">Informações Nutricionais</label>
                                    <textarea class="form-control" disabled id="informacaoNutricional" style="height: 100px;resize:none"></textarea>
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
    @endsection

    @push('scripts')
        <script>
            $('.infoProduto').on('click', function() {
                console.log(this)
                fetch(`/produto/${this.dataset.id}`).then(async (response) => {
                    let result = await response.json();

                    document.getElementById('nomeProduto').textContent = result.data.nome

                    document.getElementById('codigoProduto').value = result.data.codigo
                    document.getElementById('quantidadeEstoque').value = result.data.quantidadeEmEstoque
                    document.getElementById('unidadeMedida').value = result.data.unidade_medida
                    document.getElementById('precoCusto').value = result.data.preco_custo
                    document.getElementById('precoVenda').value = result.data.preco_venda
                    document.getElementById('fornecedorNome').value = result.data.fornecedor.nome
                    document.getElementById('marca').value = result.data.marca.nome
                    
                    let date = new Date( Date.parse(result.data.created_at) );

                    document.getElementById('dataCadastro').value = `${date.getDate()}/${date.getMonth()}/${date.getFullYear()}`
                    document.getElementById('responsavel').value = result.data.responsavel.name
                    document.getElementById('descricaoProduto').value = result.data.descricao
                    document.getElementById('informacaoNutricional').value = result.data.informacao_nutricional
                    $('#produtoModal').modal('show')
                })

            })

            document.getElementById('produtoModal').addEventListener('hide.bs.modal',function(){
                document.getElementById('formProduto').reset()
            })
        </script>
    @endpush
