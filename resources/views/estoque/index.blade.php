@extends('layouts.app')
@section('title', 'Estoque de produtos')
@section('tooltip')
    <i class="fa-solid fa-2x fa-circle-info"></i>
@endsection
@section('actions')
    <a href="{{ route('estoque.create') }}" class="btn btn-primary">
        Cadastrar produto no estoque
    </a>
@endsection


@section('content')
    <div class="d-flex">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <form class="mr-2" id="formSearch" action="{{ route('estoque.index') }}" method="GET">
                <input type="text" id="search" name="search" class="form-control" placeholder="" aria-label=""
                    aria-describedby="basic-addon1">
            </form>
            <a href="{{ route('estoque.index') }}" class="btn btn-primary">Limpar busca</a>

        </div>

        {{ $produtosEmEstoque->links() }}
    </div>
    @if (!$produtosEmEstoque->isEmpty())
        <table id="produtosTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th> Código</th>
                    <th>Nome</th>
                    <th>Preço de custo</th>
                    <th>Preço de venda</th>
                    <th>Data de entrada</th>



                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produtosEmEstoque as $produto)
                    <tr>
                        <td>{{ $produto->id }}</td>

                        <td>{{ $produto->produtoRelacionado->nome }}</td>
                        <td>{{ $produto->lote->preco_custo_unitario }}</td>
                        <td>{{ $produto->preco_venda }}</td>
                        <td>{{ \Carbon\Carbon::parse($produto->lote->created_at)->format('d/m/Y H:i') }}</td>

                        <td class="d-flex  justify-content-around">
                            <button data-id="{{ $produto->id }}" type="button"
                                class="btn btn-primary btn-sm infoProduto mr-1">
                                <i class="fas  fa-info"></i>
                            </button>

                        </td>
                    </tr>
                @endforeach
            <tfoot>


            </tfoot>
            </tbody>
        </table>
    @else
        <x-not-found />
    @endif
    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="produtoModal" tabindex="-1" aria-labelledby="produtoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="produtoModalLabel">
                        <b><span id="nomeProduto"></span></b>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formProduto">
                        <div class="row">
                            <div class="col-2">
                                <label for="exampleInputEmail1" class="form-label">Código</label>
                                <input class="form-control" id="codigoProduto" disabled>
                            </div>
                            <div class="col-2">
                                <label for="exampleInputEmail1" class="form-label">Lote</label>
                                <input class="form-control" id="loteProduto" disabled>
                            </div>
                            <div class="col-2">
                                <label for="exampleInputEmail1" class="form-label">Unidade</label>
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

                            <div class="col-4">
                                <label for="exampleInputEmail1" class="form-label">Fornecedor</label>
                                <input class="form-control" id="fornecedorNome" disabled>
                            </div>
                            <div class="col-4">
                                <label for="exampleInputEmail1" class="form-label">Marca</label>
                                <input class="form-control" id="marca" disabled>
                            </div>
                            <div class="col-4">
                                <label for="exampleInputEmail1" class="form-label">Categoria</label>
                                <input class="form-control" id="categoriaProduto" disabled>
                            </div>

                            <div class="col-6">
                                <label for="exampleInputEmail1" class="form-label">Data de validade</label>
                                <input class="form-control" id="dataValidade" disabled>
                            </div>
                            <div class="col-6">
                                <label for="exampleInputEmail1" class="form-label">Data de Entrada</label>
                                <input class="form-control" id="dataEntrada" disabled>
                            </div>

                            <div class="col-12 ">
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
                        <div class=" d-flex flex-row bg-light mt-2 p-2 rounded">
                            <div class="d-none bg-success rounded px-2 py-1 mr-1">Vendido em <span
                                    id="diasVendido"></span> dia(s)
                            </div>
                            <div class="d-none  rounded px-2 py-1 mr-1" id="produtoVencido"></div>

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
            fetch(`/api/produtoEstoqueInfo/${this.dataset.id}`).then(async (response) => {
                let result = await response.json();
                console.log(result)
                document.getElementById('nomeProduto').textContent = result.data.produto_relacionado
                    .nome

                document.getElementById('codigoProduto').value = result.data.id

                document.getElementById('precoCusto').value = result.data.lote.preco_custo_unitario
                document.getElementById('precoVenda').value = result.data.preco_venda
                document.getElementById('fornecedorNome').value = result.data.fornecedor_relacionado
                    .nome
                document.getElementById('unidadeMedida').value = result.data.produto_relacionado
                    .unidade_medida
                document.getElementById('loteProduto').value = result.data.lote.id

                document.getElementById('marca').value = result.data.marca_relacionada.nome
                document.getElementById('categoriaProduto').value = result.data.categoria_relacionada
                    .nome
                let dataEntrada = new Date(Date.parse(result.data.lote.created_at));
                let dia = dataEntrada.getDate().toString().padStart(2, '0');
                let mes = (dataEntrada.getMonth() + 1).toString().padStart(2, '0');
                let ano = dataEntrada.getFullYear();
                document.getElementById('dataEntrada').value = `${dia}/${mes}/${ano}`

                let dataValidade = new Date(Date.parse(result.data.lote.data_validade));
                dia = dataValidade.getDate().toString().padStart(2, '0');
                mes = (dataValidade.getMonth() + 1).toString().padStart(2, '0');
                ano = dataValidade.getFullYear();
                document.getElementById('dataValidade').value = `${dia}/${mes}/${ano}`

                document.getElementById('porcao').value = result.data.produto_relacionado
                    .informacao_nutricional.porcao
                document.getElementById('proteina').value = result.data.produto_relacionado
                    .informacao_nutricional.proteina
                document.getElementById('carboidrato').value = result.data.produto_relacionado
                    .informacao_nutricional.carboidrato
                document.getElementById('gordura_total').value = result.data.produto_relacionado
                    .informacao_nutricional.gordura_total

                if (result.data.diasVencimento <= 0) {
                    document.getElementById('produtoVencido').classList.add("bg-danger")
                    document.getElementById('produtoVencido').classList.remove("bg-info")

                    document.getElementById('produtoVencido').textContent =
                        `Vencido`
                } else {
                    document.getElementById('produtoVencido').classList.add("bg-info")
                    document.getElementById('produtoVencido').classList.remove("bg-danger")

                    document.getElementById('produtoVencido').textContent =
                        `Vence em ${result.data.diasAteVencimento} dia(s)`
                }
                document.getElementById('produtoVencido').classList.remove("d-none")





                document.getElementById('descricaoProduto').value = result.data.produto_relacionado
                    .descricao

                $('#produtoModal').modal('show')
            })

        })

        document.getElementById('produtoModal').addEventListener('hide.bs.modal', function() {
            console.log('a')
            document.getElementById('formProduto').reset()
            document.getElementById('diasVendido').parentNode.classList.add("d-none")
            document.getElementById('lucroVenda').classList.add("d-none")
            document.getElementById('produtoVencido').classList.add("d-none")


        })
        document.getElementById('search').addEventListener('change', function() {
            document.getElementById('formSearch').submit()
        })
    </script>
@endpush
