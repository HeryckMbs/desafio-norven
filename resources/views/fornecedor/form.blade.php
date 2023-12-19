@extends('layouts.app')
@section('title', isset($fornecedor) ? "Editar fornecedor: $fornecedor->nome" : 'Cadastrar fornecedor')


@section('content')
    <form enctype="multipart/form-data"
        action="{{ isset($fornecedor) ? route('fornecedor.update', $fornecedor->id) : route('fornecedor.store') }}"
        method="POST">
        @csrf
        @if (isset($fornecedor))
            @method('PUT')
        @endif
        <div class="">
            <div class="form-group">
                <label for="exampleInputEmail1" class="form-label">Nome</label>
                <input value="{{ isset($fornecedor) ? $fornecedor->nome : '' }}" class="form-control" name="nome"
                    id="nome">
                @error('nome')
                    <span class="mt-1  text-red p-1 rounded"><small>{{ $message }}</small></span>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="form-label">CNPJ</label>
                <input value="{{ isset($fornecedor) ? $fornecedor->cnpj : '' }}" class="form-control" name="cnpj"
                    id="cnpj">
                @error('cnpj')
                    <span class="mt-1 text-red p-1 rounded"><small>{{ $message }}</small></span>
                @enderror
            </div>
            <div class="form-group form-check">
                <input name="ativo" {{ isset($fornecedor) && $fornecedor->ativo ? 'checked' : '' }}
                    class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                <label class="form-check-label" for="flexCheckChecked">
                    Ativo
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>


    </form>



@endsection
