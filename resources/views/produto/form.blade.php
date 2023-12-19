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
                <input class="form-control" id="codigoProduto">
            </div>
            <div class="col-6">
                <label for="exampleInputEmail1" class="form-label">Código do Produto</label>
                <input class="form-control" id="quantidadeEstoque">
            </div>
            <div class="col-3">
                <label for="exampleInputEmail1" class="form-label">Data de cadastro</label>
                <input class="form-control" id="dataCadastro">
            </div>
            <div class="col-3">
                <label for="exampleInputEmail1" class="form-label">Unidade de Medida</label>
                <input class="form-control" id="unidadeMedida">
            </div>

            <div class="col-3">
                <label for="exampleInputEmail1" class="form-label">Preço de custo</label>
                <input class="form-control" id="precoCusto">
            </div>
            <div class="col-3">
                <label for="exampleInputEmail1" class="form-label">Preço de Venda</label>
                <input class="form-control" id="precoVenda">
            </div>

            <div class="col-6">
                <label for="exampleInputEmail1" class="form-label">Fornecedor</label>
                <select class="form-select" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
            <div class="col-6">
                <label for="exampleInputEmail1" class="form-label">Marca</label>
                <select class="" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
            <div class="col-6">
                <label for="exampleInputEmail1" class="form-label">Categoria</label>
                <select class="form-select" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
            <div class="col-6">
                <label for="exampleInputEmail1" class="form-label">Responsável</label>
                <input class="form-control" id="responsavel" disabled value="{{ Auth::user()->name }}">
            </div>
            <div class="col-6 mt-1">
                <div class="form-floating">
                    <label for="floatingTextarea2">Descrição</label>
                    <textarea class="form-control" id="descricaoProduto" style="height: 100px;resize:none"></textarea>
                </div>
            </div>
            <div class="col-6 mt-1">
                <div class="form-floating">
                    <label for="floatingTextarea2">Informações Nutricionais</label>
                    <textarea class="form-control" id="informacaoNutricional" style="height: 100px;resize:none"></textarea>
                </div>
            </div>

        </div>
        {{-- 
            <div class="form-group">
                <label for="exampleInputEmail1" class="form-label">Nome</label>
                <input value="{{ isset($produto) ? $produto->nome : '' }}" class="form-control" name="nome"
                    id="nome">
                @error('nome')
                    <span class="mt-1  text-red p-1 rounded"><small>{{ $message }}</small></span>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="form-label">CNPJ</label>
                <input value="{{ isset($produto) ? $produto->cnpj : '' }}" class="form-control" name="cnpj"
                    id="cnpj">
                @error('cnpj')
                    <span class="mt-1 text-red p-1 rounded"><small>{{ $message }}</small></span>
                @enderror
            </div>
            <div class="form-group form-check">
                <input name="ativo" {{ isset($produto) && $produto->ativo ? 'checked' : '' }} class="form-check-input"
                    type="checkbox" value="" id="flexCheckChecked">
                <label class="form-check-label" for="flexCheckChecked">
                    Ativo
                </label>
            </div> --}}
        <button type="submit" class="btn btn-primary">Salvar</button>


    </form>



@endsection
