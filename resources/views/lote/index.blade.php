@extends('layouts.app')
@section('title', 'Lote de produtos')

@section('actions')
    <a href="{{ route('lote.create') }}" class="btn btn-primary">
        Cadastrar lote de produtos
    </a>
@endsection


@section('content')
<form class="mr-2 d-flex justify-content-between" id="formSearch" action="{{ route('lote.index') }}" method="GET">
    <div class="d-flex ">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input value="{{ $_GET['search'] ?? '' }}" type="text" id="search" name="search" class="form-control"
                placeholder="" aria-label="" aria-describedby="basic-addon1">
            <a href="{{ route('lote.index') }}" class="btn btn-primary">Limpar busca</a>

        </div>
    </div>
    <div class="d-flex">
        <div class="input-group  ">
            <select id="paginacao" name="paginacao" class="custom-select mr-2" style="min-width: 80px"
                id="inputGroupSelect01">
                <option value="10" {{ isset($_GET['paginacao']) && $_GET['paginacao'] == '10' ? 'selected' : '' }}>
                    10
                </option>
                <option value="20" {{ isset($_GET['paginacao']) && $_GET['paginacao'] == '20' ? 'selected' : '' }}>
                    20
                </option>
                <option value="30" {{ isset($_GET['paginacao']) && $_GET['paginacao'] == '30' ? 'selected' : '' }}>
                    30
                </option>


            </select>
            {{ $produtosEmEstoque->links() }}

        </div>
    </div>
</form>

    @if (!$produtosEmEstoque->isEmpty())
        <table id="produtosTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th> Código do lote</th>
                    <th>Produto</th>
                    <th>Quantidade Atual</th>

                    <th>Preço de custo (R$)</th>
                    <th>Preço de venda (R$)</th>
                    <th>Data de entrada</th>
                    <th>Data de Validade</th>
                    <th>Vencido</th>



                    <th class="text-center">Informações do produto</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produtosEmEstoque as $produto)
                    <tr
                        @if ($produto->vencido) style="background-color:#ff8e8e"
                    @elseif($produto->quantidadeAtual < 100)
                    style="background-color:#ffc967" @endif>
                        <td>{{ $produto->id }}</td>
                        <td>{{ $produto->produto->nome }}

                        <td>{{ $produto->quantidadeAtual }}
                            {{-- -
                        <span class="{{$produto->quantidadeAtual < 100 ? 'bg-danger': 'bg-info'}} rounded p-1">{{$produto->quantidadeAtual < 100 ? 'Baixo': 'Normal'}}</span> --}}
                        </td>

                        <td>{{ $produto->preco_custo }}</td>
                        <td>{{ $produto->preco_venda }}</td>

                        {{-- 
                        <td>{{ $produto->produtoRelacionado->nome }}</td>
                        --}}
                        <td>{{ \Carbon\Carbon::parse($produto->created_at)->format('d/m/Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($produto->data_validade)->format('d/m/Y') }}</td>
                        <td>{{ $produto->vencido ? 'Sim' : 'Não' }}</td>

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

    @include('lote.modalInfo')


@endsection

@push('scripts')
    <script>
        $('.infoProduto').on('click', function() {
            console.log(`/lote/${this.dataset.id}`)
            fetch(`/lote/${this.dataset.id}`).then(async (response) => {
                let result = await response.json();
                console.log(result)
                document.getElementById('nomeProduto').textContent = result.data.produto
                    .nome

                document.getElementById('loteProduto').value = result.data.id

                document.getElementById('precoCusto').value = result.data.preco_custo
                document.getElementById('precoVenda').value = result.data.preco_venda
                document.getElementById('fornecedorNome').value = result.data.produto.fornecedor
                    .nome
                document.getElementById('unidadeMedida').value = result.data.produto
                    .unidade_medida
                document.getElementById('loteProduto').value = result.data.id

                document.getElementById('marca').value = result.data.produto.marca.nome
                document.getElementById('categoriaProduto').value = result.data.produto.categoria.nome

                let dataEntrada = new Date(Date.parse(result.data.created_at));
                let dia = dataEntrada.getDate().toString().padStart(2, '0');
                let mes = (dataEntrada.getMonth() + 1).toString().padStart(2, '0');
                let ano = dataEntrada.getFullYear();
                document.getElementById('dataEntrada').value = `${dia}/${mes}/${ano}`

                let dataValidade = new Date(Date.parse(result.data.data_validade));
                dia = dataValidade.getDate().toString().padStart(2, '0');
                mes = (dataValidade.getMonth() + 1).toString().padStart(2, '0');
                ano = dataValidade.getFullYear();
                document.getElementById('dataValidade').value = `${dia}/${mes}/${ano}`

                let dataFabricacao = new Date(Date.parse(result.data.data_fabricacao));
                dia = dataFabricacao.getDate().toString().padStart(2, '0');
                mes = (dataFabricacao.getMonth() + 1).toString().padStart(2, '0');
                ano = dataFabricacao.getFullYear();
                document.getElementById('dataFabricacao').value = `${dia}/${mes}/${ano}`


                
                document.getElementById('porcao').value = result.data.produto
                    .informacao_nutricional.porcao
                document.getElementById('proteina').value = result.data.produto
                    .informacao_nutricional.proteina
                document.getElementById('carboidrato').value = result.data.produto
                    .informacao_nutricional.carboidrato
                document.getElementById('gordura_total').value = result.data.produto
                    .informacao_nutricional.gordura_total

                if (result.data.diasAteVencimento <= 0) {
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





                document.getElementById('descricaoProduto').value = result.data.produto
                    .descricao

                $('#produtoModal').modal('show')
            })

        })

        document.getElementById('produtoModal').addEventListener('hide.bs.modal', function() {
            document.getElementById('formProduto').reset()
            document.getElementById('produtoVencido').classList.add("d-none")
        })
        document.getElementById('search').addEventListener('change', function() {
            document.getElementById('formSearch').submit()
        })

        document.getElementById('paginacao').addEventListener('change', function() {
            document.getElementById('formSearch').submit()
        })
    </script>
@endpush
