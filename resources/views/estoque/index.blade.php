@extends('layouts.app')
@section('title', 'Estoque de produtos')

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
    <table id="produtosTable" class="table table-striped table-hover">
        <thead>
            <tr>
                <th> Código</th>
                <th>Nome</th>
                <th>Preço de custo</th>
                <th>Preço de venda</th>

                <th>Data de validade</th>
                <th>Dias até Vencimento</th>

                <th>Em estoque</th>
                <th>Vendido</th>

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
                    <td>{{ \Carbon\Carbon::parse($produto->lote->data_validade)->format('d/m/Y') }}</td>
                    <td>{{ $produto->diasAteVencimento }}
                    </td>

                    <td>{!! $produto->deleted_at == null
                        ? '<span class="bg-success p-1 rounded">Sim</span>'
                        : '<span class="bg-danger p-1 rounded">Não</span>' !!}</td>

                    <td>{!! $produto->vendido
                        ? '<span class="bg-success p-1 rounded">Sim</span>'
                        : '<span class="bg-danger p-1 rounded">Não</span>' !!}</td>

                    <td class="d-flex  justify-content-around">
                        <button data-id="{{ $produto->id }}" type="button" class="btn btn-primary infoProduto mr-1">
                            <i class="fas fa-info"></i>
                        </button>

                    </td>
                </tr>
            @endforeach
        <tfoot>


        </tfoot>
        </tbody>
    </table>
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
                            <div class="col-1">
                                <label for="exampleInputEmail1" class="form-label">Código</label>
                                <input class="form-control" id="codigoProduto" disabled>
                            </div>
                            <div class="col-3">
                                <label for="exampleInputEmail1" class="form-label" data-toggle="tooltip"
                                    data-placement="top" title="Código da categoria - Prateleira - Posição">Posição no
                                    estoque</label>
                                <input data-toggle="tooltip" data-placement="top"
                                    title="Código da categoria - Prateleira - Posição" class="form-control"
                                    id="posicaoEstoque" disabled>

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
                            <div class="col-2">
                                <label for="exampleInputEmail1" class="form-label">Lote</label>
                                <input class="form-control" id="loteProduto" disabled>
                            </div>
                            <div class="col-4">
                                <label for="exampleInputEmail1" class="form-label">Data de validade</label>
                                <input class="form-control" id="dataValidade" disabled>
                            </div>
                            <div class="col-3">
                                <label for="exampleInputEmail1" class="form-label">Data de Entrada</label>
                                <input class="form-control" id="dataEntrada" disabled>
                            </div>

                            <div class="col-3">
                                <label for="exampleInputEmail1" class="form-label">Data de Venda</label>
                                <input class="form-control" id="dataVenda" disabled>
                            </div>

                            <div class="col-6 ">
                                <div class="form-floating">
                                    <label for="floatingTextarea2">Descrição</label>
                                    <textarea class="form-control" id="descricaoProduto" disabled style="height: 100px;resize:none"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating">
                                    <label for="floatingTextarea2">Informações Nutricionais</label>
                                    <textarea class="form-control" disabled id="informacaoNutricional" style="height: 100px;resize:none"></textarea>
                                </div>
                            </div>

                        </div>
                        <div class=" d-flex flex-row bg-light mt-2 p-2 rounded">
                            <div class="d-none bg-success rounded px-2 py-1 mr-1">Vendido em <span
                                    id="diasVendido"></span> dia(s)
                            </div>
                            <div class="d-none  rounded px-2 py-1 mr-1" id="lucroVenda"> </div>
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
            fetch(`/produtoEstoqueInfo/${this.dataset.id}`).then(async (response) => {
                let result = await response.json();
                console.log(result)
                document.getElementById('nomeProduto').textContent = result.data.produto_relacionado
                    .nome

                document.getElementById('codigoProduto').value = result.data.id
                // document.getElementById('posicaoEstoque').value =
                //     `${result.data.categoria_relacionada.id} - ${result.data.localizacao_estoque.prateleira} - ${result.data.localizacao_estoque.posicao} `
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
                let dataEntrada = new Date(Date.parse(result.data.lote.data_entrada));
                document.getElementById('dataEntrada').value =
                    `${dataEntrada.getDate()}/${dataEntrada.getMonth()}/${dataEntrada.getFullYear()}`

                let dataValidade = new Date(Date.parse(result.data.lote.data_validade));
                document.getElementById('dataValidade').value =
                    `${dataValidade.getDate()}/${dataValidade.getMonth()}/${dataValidade.getFullYear()}`
                if (result.data.vendido) {
                    const lucro = result.data.lucro
                    if (lucro > 0) {
                        document.getElementById('lucroVenda').classList.add("bg-success")
                        document.getElementById('lucroVenda').textContent =
                            `Lucro de ${lucro.toFixed(2)}%`
                    } else {
                        document.getElementById('lucroVenda').classList.add("bg-danger")
                        document.getElementById('lucroVenda').textContent =
                            `Prejuízo de ${lucro.toFixed(2)}%`
                    }

                    let date = new Date(Date.parse(result.data.deleted_at));
                    document.getElementById('dataVenda').value =
                        `${date.getDate()}/${date.getMonth()}/${date.getFullYear()}`

                    document.getElementById('lucroVenda').classList.remove("d-none")
                    document.getElementById('diasVendido').textContent = result.data.diasVendido;
                    document.getElementById('diasVendido').parentNode.classList.remove("d-none")

                }

                if (result.data.diasVencimento <= 0) {
                    document.getElementById('produtoVencido').classList.add("bg-danger")
                    document.getElementById('produtoVencido').classList.remove("bg-info")

                    document.getElementById('produtoVencido').textContent =
                        `Vencido`
                } else {
                    document.getElementById('produtoVencido').classList.add("bg-info")
                    document.getElementById('produtoVencido').classList.remove("bg-danger")

                    document.getElementById('produtoVencido').textContent =
                        `Vence em ${result.data.diasVencimento} dia(s)`
                }
                document.getElementById('produtoVencido').classList.remove("d-none")





                document.getElementById('descricaoProduto').value = result.data.produto_relacionado
                    .descricao
                document.getElementById('informacaoNutricional').value = result.data.produto_relacionado
                    .informacao_nutricional
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
