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
                <th>Id</th>
                <th>Nome</th>
                <th>Código</th>
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
                    <td>{{ $produto->produtoRelacionado->codigo }}</td>
                    <td>{{ $produto->preco_custo }}</td>
                    <td>{{ $produto->preco_venda }}</td>

                    <td>{{ \Carbon\Carbon::parse($produto->data_validade)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($produto->data_validade)) }}
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
                        @if ($produto->deleted_at == null)
                            <a href="{{ route('produto.edit', $produto->id) }}" type="button"
                                class="btn btn-warning mr-1 "><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('produto.destroy', $produto->id) }}"
                                enctype="multipart/form-data">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>

                            </form>
                        @endif


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
                            <div class="col-6">
                                <label for="exampleInputEmail1" class="form-label">Código do Produto</label>
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
                                <label for="exampleInputEmail1" class="form-label">Data de Entrada</label>
                                <input class="form-control" id="dataEntrada" disabled>
                            </div>
                            <div class="col-6">
                                <label for="exampleInputEmail1" class="form-label">Marca</label>
                                <input class="form-control" id="marca" disabled>
                            </div>
                            <div class="col-6">
                                <label for="exampleInputEmail1" class="form-label">Data de Entrada</label>
                                <input class="form-control" id="dataEntrada" disabled>
                            </div>
                            <div class="col-12">
                                <label for="exampleInputEmail1" class="form-label">Categoria</label>
                                <input class="form-control" id="categoriaProduto" disabled>
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

                document.getElementById('codigoProduto').value = result.data.produto_relacionado.codigo
                document.getElementById('posicaoEstoque').value =
                    `${result.data.categoria_relacionada.id} - ${result.data.localizacao_estoque.prateleira} - ${result.data.localizacao_estoque.posicao} `
                document.getElementById('precoCusto').value = result.data.preco_custo
                document.getElementById('precoVenda').value = result.data.preco_venda
                document.getElementById('fornecedorNome').value = result.data.fornecedor_relacionado
                    .nome
                document.getElementById('unidadeMedida').value = result.data.produto_relacionado
                    .unidade_medida

                document.getElementById('marca').value = result.data.marca_relacionada.nome
                document.getElementById('categoriaProduto').value = result.data.categoria_relacionada
                    .nome
                let date = new Date(Date.parse(result.data.data_entrada));


                if (result.data.vendido) {
                    const lucro = result.data.lucro
                    console.log()
                    if (lucro > 0) {
                        document.getElementById('lucroVenda').classList.add("bg-success")
                        document.getElementById('lucroVenda').textContent =
                            `Lucro de ${lucro.toFixed(2)}%`
                    } else {
                        document.getElementById('lucroVenda').classList.add("bg-danger")
                        document.getElementById('lucroVenda').textContent =
                            `Prejuízo de ${lucro.toFixed(2)}%`
                    }

                    document.getElementById('lucroVenda').classList.remove("d-none")
                    document.getElementById('diasVendido').textContent = result.data.diasVendido;
                    document.getElementById('diasVendido').parentNode.classList.remove("d-none")
                    document.getElementById('lucroVenda').classList.add("bg-danger")
                    document.getElementById('lucroVenda').textContent =
                        `Prejuízo de ${lucro.toFixed(2)}%`
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





                document.getElementById('dataEntrada').value =
                    `${date.getDate()}/${date.getMonth()}/${date.getFullYear()}`
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

        function getDiffDays(dataInicial, dataFinal) {
            let date1 = new Date(Date.parse(dataInicial));
            let date2 = new Date(Date.parse(dataFinal))

            let diffTime = Math.abs(date2 - date1);
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            return diffDays;
        }

        function getDiffDaysWithToday(data) {
            let date1 = new Date();
            let date2 = new Date(Date.parse(data))

            let diffTime = Math.abs(date2 - date1);
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            return diffDays;
        }
    </script>
@endpush
