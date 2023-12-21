@extends('layouts.app')
@section('title', isset($produto) ? "Editar produto: $produto->nome" : 'Cadastrar produtos no estoque')


@section('content')
    <form enctype="multipart/form-data"
        action="{{ isset($produto) ? route('produto.update', $produto->id) : route('produto.store') }}" method="POST">
        @csrf
        @if (isset($produto))
            @method('PUT')
        @endif
        <div class="row">
            <div class="col-3 ">
                <label for="exampleInputEmail1" class="form-label">Categoria</label>
                <div class="input-group  ">
                    <select id="categoria" name="categoria"
                        value="{{ isset($produto) ? $produto->categoria_id : old('categoria') ?? '' }}"
                        class="custom-select" id="inputGroupSelect01">
                        <option value="-1" selected>Selecione uma opção
                        <option>
                            @foreach ($categorias as $categoria)
                        <option
                            {{ isset($produto) ? ($produto->categoria_id == $categoria->id ? 'selected' : '') : (old('categoria') == $categoria->id ? 'selected' : '') }}
                            value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                        @endforeach
                    </select>
                </div>
                @error('categoria')
                    <span class="mt-1  text-red p-1 rounded"><small>{{ $message }}</small></span>
                @enderror
            </div>
            <div class="col-3 ">
                <label for="exampleInputEmail1" class="form-label">Categoria</label>
                <div class="input-group  ">
                    <select id="produto" name="produto"
                        value="{{ isset($produto) ? $produto->categoria_id : old('categoria') ?? '' }}"
                        class="custom-select" id="inputGroupSelect01">
                        <option value="-1" selected>Selecione uma categoria

                    </select>
                </div>
                @error('categoria')
                    <span class="mt-1  text-red p-1 rounded"><small>{{ $message }}</small></span>
                @enderror
            </div>
            <div class="col-3">
                <label for="exampleInputEmail1" class="form-label">Quantidade de Produtos</label>
                <input type="number" name="nome"
                    value="{{ isset($produto) ? $produto->nome : (isset($produto) ? $produto->nome : old('nome') ?? '') }}"
                    class="form-control" id="codigoProduto">
                @error('nome')
                    <span class="mt-1  text-red p-1 rounded"><small>{{ $message }}</small></span>
                @enderror
            </div>

            <div class="col-3">
                <label for="exampleInputEmail1" class="form-label">Preço de custo</label>
                <input type="number" name="preco_custo"
                    value="{{ isset($produto) ? $produto->preco_custo : old('preco_custo') ?? '' }}" class="form-control"
                    id="preco_custo">
                @error('preco_custo')
                    <span class="mt-1  text-red p-1 rounded"><small>{{ $message }}</small></span>
                @enderror
            </div>

            <div class="col-6">
                <label for="exampleInputEmail1" class="form-label">Responsável</label>
                <input name="responsavel" class="form-control" id="responsavel" disabled value="{{ Auth::user()->name }}">
                @error('responsavel')
                    <span class="mt-1  text-red p-1 rounded"><small>{{ $message }}</small></span>
                @enderror
            </div>


        </div>

        <button type="submit" class="btn btn-primary mt-2">Salvar</button>


    </form>


    <script>
        document.getElementById('categoria').addEventListener('change', function() {
            console.log(this)
            if (this.value != -1) {
                fetch(`/produtosCategoria/${this.value}`).then(async (response) => {
                    let result = await response.json();

                    $('#produto').empty();
                    for (let item of result.data) {
                        $('#produto').append(`<option value="${item.id}">${item.nome}</option>`)
                    }
                    console.log(result)

                })
            }

        })
    </script>
@endsection
