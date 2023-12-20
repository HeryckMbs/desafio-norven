@extends('layouts.app')
@section('title', isset($produto) ? "Editar produto: $produto->nome" : 'Cadastrar produto')


@section('content')
    <form enctype="multipart/form-data"
        action="{{ isset($produto) ? route('produto.update', $produto->id) : route('produto.store') }}" method="POST">
        @csrf
        @if (isset($produto))
            @method('PUT')
        @endif
        <div class="row">
            <div class="col-6">
                <label for="exampleInputEmail1" class="form-label">Nome</label>
                <input name="nome"
                    value="{{ isset($produto) ? $produto->nome : (isset($produto) ? $produto->nome : old('nome') ?? '') }}"
                    class="form-control" id="codigoProduto">
                @error('nome')
                    <span class="mt-1  text-red p-1 rounded"><small>{{ $message }}</small></span>
                @enderror
            </div>
            <div class="col-6">
                <label for="exampleInputEmail1" class="form-label">Código do Produto</label>
                <input name="codigo" value="{{ isset($produto) ? $produto->codigo : old('codigo') ?? '' }}"
                    class="form-control" id="quantidadeEstoque">
                @error('codigo')
                    <span class="mt-1  text-red p-1 rounded"><small>{{ $message }}</small></span>
                @enderror
            </div>
            <div class="col-3">
                <label for="exampleInputEmail1" class="form-label">Unidade de Medida</label>
                <input name="unidade_medida"
                    value="{{ isset($produto) ? $produto->unidade_medida : old('unidade_medida') ?? '' }}"
                    class="form-control" id="unidadeMedida">
                @error('unidade_medida')
                    <span class="mt-1  text-red p-1 rounded"><small>{{ $message }}</small></span>
                @enderror
            </div>

            <div class="col-2">
                <label for="exampleInputEmail1" class="form-label">Preço de custo</label>
                <input type="number" name="preco_custo"
                    value="{{ isset($produto) ? $produto->preco_custo : old('preco_custo') ?? '' }}" class="form-control"
                    id="preco_custo">
                @error('preco_custo')
                    <span class="mt-1  text-red p-1 rounded"><small>{{ $message }}</small></span>
                @enderror
            </div>
            <div class="col-2">
                <label for="exampleInputEmail1" class="form-label">Preço de Venda</label>
                <input type="number" name="preco_venda"
                    value="{{ isset($produto) ? $produto->preco_venda : old('preco_venda') ?? '' }}" class="form-control"
                    id="preco_venda">
                @error('preco_venda')
                    <span class="mt-1  text-red p-1 rounded"><small>{{ $message }}</small></span>
                @enderror
            </div>

            <div class="col-5 ">
                <label for="exampleInputEmail1" class="form-label">Categoria</label>
                <div class="input-group  ">
                    <select name="categoria"
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
            <div class="col-6 ">
                <label for="exampleInputEmail1" class="form-label">Marca</label>
                <div class="input-group  ">

                    <select name="marca" value="{{ isset($produto) ? $produto->nome : old('marca') }}"
                        class="custom-select" id="inputGroupSelect01">
                        <option value="-1" selected>Selecione uma opção
                        <option>
                            @foreach ($marcas as $marca)
                        <option
                        {{ isset($produto) ? ($produto->marca_id == $marca->id ? 'selected' : '') : (old('marca') == $marca->id ? 'selected' : '') }}
                        value="{{ $marca->id }}">{{ $marca->nome }}</option>
                        @endforeach
                    </select>
                </div>
                @error('marca')
                    <span class="mt-1  text-red p-1 rounded"><small>{{ $message }}</small></span>
                @enderror
            </div>
            <div class="col-6 ">
                <label for="exampleInputEmail1" class="form-label">Fornecedores</label>
                <div class="input-group  ">

                    <select name="fornecedor" value="{{ isset($produto) ? $produto->nome : old('fornecedor') ?? '' }}"
                        class="custom-select" id="inputGroupSelect01">
                        <option value="-1" selected>Selecione uma opção
                        <option>
                            @foreach ($fornecedores as $fornecedor)
                        <option
                        {{ isset($produto) ? ($produto->fornecedor_id == $fornecedor->id ? 'selected' : '') : (old('fornecedor') == $fornecedor->id ? 'selected' : '') }}
                            value="{{ $fornecedor->id }}">{{ $fornecedor->nome }}</option>
                        @endforeach
                    </select>
                </div>
                @error('fornecedor')
                    <span class="mt-1  text-red p-1 rounded"><small>{{ $message }}</small></span>
                @enderror
            </div>
            <div class="col-12">
                <label for="exampleInputEmail1" class="form-label">Responsável</label>
                <input name="responsavel" class="form-control" id="responsavel" disabled value="{{ Auth::user()->name }}">
                @error('responsavel')
                    <span class="mt-1  text-red p-1 rounded"><small>{{ $message }}</small></span>
                @enderror
            </div>
            <div class="col-6 mt-1">
                <div class="form-floating">
                    <label for="floatingTextarea2">Descrição</label>
                    <textarea name="descricao" value="" class="form-control"
                        id="descricao" style="height: 100px;resize:none">
                        {{ isset($produto) ? $produto->descricao : old('descricao') ?? '' }}</textarea>
                    @error('descricao')
                        <span class="mt-1  text-red p-1 rounded"><small>{{ $message }}</small></span>
                    @enderror
                </div>
            </div>
            <div class="col-6 mt-1">
                <div class="form-floating">
                    <label for="floatingTextarea2">Informações Nutricionais</label>
                    <textarea name="informacaoNutricional"
                        value="" class="form-control"
                        id="informacaoNutricional" style="height: 100px;resize:none">{{ isset($produto) ? $produto->informacao_nutricional : old('informacaoNutricional') ?? '' }}</textarea>
                    @error('informacaoNutricional')
                        <span class="mt-1  text-red p-1 rounded"><small>{{ $message }}</small></span>
                    @enderror
                </div>
            </div>

        </div>

        <button type="submit" class="btn btn-primary mt-2">Salvar</button>


    </form>



@endsection
