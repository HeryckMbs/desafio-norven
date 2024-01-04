@extends('layouts.app')
@section('title', isset($produto) ?: 'Cadastrar saída de produtos')


@section('content')
    <form enctype="multipart/form-data" action="{{ route('lancamento.store') }}" method="POST">
        @csrf
        @if (isset($produto))
            @method('PUT')
        @endif
        <div class="row">
            <div class="col-4">
                <label for="exampleInputEmail1" class="form-label">Código do Lote</label>
                <input type="number" value="" name="lote_id" class="form-control" id="codigoProduto">
                @error('lote_id')
                    <span class="mt-1  text-red p-1 rounded"><small>{{ $message }}</small></span>
                @enderror
                <label for="exampleInputEmail1" class="form-label">Quantidade de Produtos</label>
                <input type="number" name="quantidade" value="" class="form-control" id="quantidade">
                @error('quantidade')
                    <span class="mt-1  text-red p-1 rounded"><small>{{ $message }}</small></span>
                @enderror
                <div class="mt-1">
                    <label for="exampleInputEmail1" class="form-label">Responsável</label>
                    <input name="responsavel" class="form-control" id="responsavel" disabled
                        value="{{ Auth::user()->name }}">

                </div>
                <button id="submitButton" type="submit" class="btn btn-primary mt-3">Salvar</button>

            </div>
            <div class="col-4 bg-info rounded my-5 mx-2 p-3" id="infoLote" style="height: 20%">
                <strong>Informações do Lote</strong><i class="fa fa-info-circle ml-2" aria-hidden="true"></i>

                <hr class="my-1">
                <div> Código do lote: <span id="codigoLote"> </span></div>
                <div> Nome do produto: <span id="nomeProduto"> </span></div>
                <div> Quantidade em estoque: <span id="quantidadeEstoque"> </span></div>

            </div>

        </div>






    </form>
    <input type="hidden"  id="quantidadeAtual">

    <script>
        let products = [];
        document.getElementById('codigoProduto').addEventListener('change', function() {
            fetch(`/lote/${this.value}`).then(async (response) => {
                let result = await response.json();
                console.log(response)
                if(response.status == 400){
                    Toast.fire({
                    heightAuto: true,
                    icon: 'error',
                    title: result.message
                });
                }else{      
                    console.log(response)
                    document.getElementById('codigoLote').textContent = result.data.id
                    document.getElementById('nomeProduto').textContent = result.data.produto.nome
                    document.getElementById('quantidadeEstoque').textContent = result.data.quantidadeAtual
                    document.getElementById('quantidadeAtual').value = result.data.quantidadeAtual

                }
            })

        })

        document.getElementById('quantidade').addEventListener('change', function() {
            let valorMaximo = parseInt(document.getElementById('quantidadeAtual').value);
            let valorRetirada = parseInt(this.value)
            if(valorRetirada > valorMaximo){
                Toast.fire({
                    heightAuto: true,
                    icon: 'error',
                    title: 'A quantidade a ser retirada não pode ser maior que a quantidade em estoque atual!'
                });
                document.getElementById('submitButton').setAttribute('disabled','')
            }else{
                document.getElementById('submitButton').removeAttribute('disabled')

            }
        })
    </script>
@endsection
