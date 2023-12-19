@extends('layouts.app')
@section('title', (isset($categoria) ? "Editar categoria $categoria->nome" :'Cadastrar categoria'))


@section('content')
<form enctype="multipart/form-data" action="{{ isset($categoria) ? route('categoria.update',$categoria->id) : route('categoria.store') }}"
        method="POST">
        @csrf
        @if(isset($categoria))
            @method('PUT')
        @endif
        <div class="row">
            <div class="col-6">
                <label for="exampleInputEmail1" class="form-label">Nome</label>
                <input value="{{isset($categoria) ? $categoria->nome : ''}}" class="form-control" name="nome" id="nome">
                @error('nome')
                    <span class="mt-1  text-red p-1 rounded"><small>{{ $message }}</small></span>
                @enderror
            </div>
            <div class="col-6">
                <label for="exampleInputEmail1" class="form-label">Url da foto</label>
                <input value="{{isset($categoria) ? $categoria->url_capa : ''}}" class="form-control" name="url_capa" id="url_capa">
                @error('url_capa')
                    <span class="mt-1 text-red p-1 rounded"><small>{{ $message }}</small></span>
                @enderror
            </div>

        </div>
        <div class="row">
            <div class="col-12 mt-1">
                <div class="form-floating">
                    <label for="floatingTextarea2">Descrição</label>
                    <textarea name="descricao" class="form-control" id="descricaoCategoria" style="height: 100px;resize:none">{{isset($categoria) ? $categoria->descricao : '' }}</textarea>
                    @error('descricao')
                        <span class="mt-1 text-red p-1 rounded"><small>{{ $message }}</small></span>
                    @enderror
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Salvar</button>

    </form>



@endsection

