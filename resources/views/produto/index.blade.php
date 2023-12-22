@extends('layouts.app')
@section('title', 'Produtos')

@section('actions')
    <a href="{{ route('produto.create') }}" class="btn btn-primary">
        Cadastrar produto
    </a>
@endsection


@section('content')
    <form class="d-flex flex-row justify-content-around" id="formSearch" action="{{ route('produto.index') }}" method="GET">


            <div  class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                </div>
                <input value="{{$_GET['search'] ?? ''}}" style="max-width: 150px" type="text" id="search" name="search" class="form-control mr-2" placeholder="" aria-label=""
                    aria-describedby="basic-addon1">
                <a href="{{ route('produto.index') }}" class="btn btn-primary">Limpar busca</a>

            </div>
            <div class="d-flex">
                <div class="input-group  ">
                    <select id="paginacao" name="paginacao"
                        class="custom-select mr-2" style="min-width: 80px" id="inputGroupSelect01">
                        <option value="10" {{isset($_GET['paginacao']) && $_GET['paginacao'] == '10' ? 'selected':''}}>10</option>
                        <option value="20" {{isset($_GET['paginacao']) && $_GET['paginacao'] == '20' ? 'selected':''}}>20</option>
                        <option value="30" {{isset($_GET['paginacao']) && $_GET['paginacao'] == '30' ? 'selected':''}}>30</option>


                    </select>
                </div>
                {{ $produtos->links() }}
            </div>
    </form>

    <table id="produtosTable" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Categoria</th>

                <th>Descrição</th>
                <th>Responsável</th>
                <th>Ativo</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produtos as $produto)
                <tr class="{{ $produto->deleted_at ? 'bg-danger' : '' }}">
                    <td>{{ $produto->id }}</td>

                    <td>{{ $produto->nome }}</td>
                    <td>{{ $produto->categoria->nome }}</td>

                    <td style="text-overflow: ellipsis">{{ $produto->descricao }}</td>
                    <td>{{ $produto->responsavel->name }}</td>
                    <td>{{ $produto->deleted_at == null ? 'Ativo' : 'Inativo' }}</td>


                    <td class="d-flex  justify-content-around">
                        @if ($produto->deleted_at == null)
                            <button data-id="{{ $produto->id }}" type="button" class="btn btn-primary infoProduto mr-1">
                                <i class="fas fa-info"></i>
                            </button>
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
                    <h5 class="modal-title" id="produtoModalLabel">Informações do produto: <b><span
                                id="nomeProduto"></span></b>
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
    </div>


@endsection

@push('scripts')
    <script>
        $('.infoProduto').on('click', function() {
            console.log(this)
            fetch(`/produtoIndividual/${this.dataset.id}`).then(async (response) => {
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

                document.getElementById('dataCadastro').value =
                    `${date.getDate()}/${date.getMonth()}/${date.getFullYear()}`
                document.getElementById('responsavel').value = result.data.responsavel.name
                document.getElementById('descricaoProduto').value = result.data.descricao
                document.getElementById('informacaoNutricional').value = result.data
                    .informacao_nutricional
                $('#produtoModal').modal('show')
            })

        })

        document.getElementById('produtoModal').addEventListener('hide.bs.modal', function() {
            document.getElementById('formProduto').reset()
        })
        document.getElementById('search').addEventListener('change', function() {
            document.getElementById('formSearch').submit()
        })
        document.getElementById('paginacao').addEventListener('change', function() {
            document.getElementById('formSearch').submit()
        })
    </script>
@endpush
