@extends('layouts.app')
@section('title', 'Produtos')

@section('actions')
    <a href="{{ route('produto.create') }}" class="btn btn-primary">
        Cadastrar produto
    </a>
@endsection


@section('content')
<div class="d-flex">

    <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
        </div>
        <form class="mr-2" id="formSearch" action="{{route('produto.index')}}" method="GET">
            <input type="text" id="search" name="search" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
        </form>
        <a href="{{ route('produto.index') }}" class="btn btn-primary">Limpar busca</a>

      </div>
    {{$produtos->links() }}
</div>
    <table id="produtosTable" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Produto</th>
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
    </div>




@endsection

@push('scripts')
    <script>

        $('.infoProduto').on('click', function() {
            console.log(this)
            fetch(`/produtoIndividual/${this.dataset.id}`).then(async (response) => {
                let result = await response.json();
                console.log(result)
                document.getElementById('nomeProduto').textContent = result.data.nome

                document.getElementById('codigoProduto').value = result.data.codigo
                document.getElementById('quantidadeEstoque').value = result.data.quantidadeEmEstoque
                document.getElementById('unidadeMedida').value = result.data.unidade_medida
                document.getElementById('precoCusto').value = result.data.preco_custo
                document.getElementById('precoVenda').value = result.data.preco_venda
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
    </script>
@endpush
