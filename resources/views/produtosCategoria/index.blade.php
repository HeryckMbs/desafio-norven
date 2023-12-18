@extends('layouts.app')
@section('title', 'Produtos da Categoria: '.$categoria->nome)

@section('actions')
    <button data-target="#modalRequest" data-toggle="modal" class="btn btn-primary">Adicionar
        novo Serviço</button>

@endsection


@section('content')

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Produto</th>
                <th>Código</th>
                <th>Data de Validade</th>
                <th>Lote</th>
                <th>Responsável</th>
                <th>Quantidade em estoque</th>
                <th class="d-flex justify-content-center">Informações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produtosCategoria as $produtoEmEstoque)
            <tr>
                    <td>{{$produtoEmEstoque->id}}</td>
                    <td>{{$produtoEmEstoque->produto->nome}}</td>
                    <td>{{$produtoEmEstoque->produto->codigo}}</td>
                    <td>{{ \Carbon\Carbon::parse($produtoEmEstoque->produto->data_validade)->format('d/m/Y')}}</td>
                    <td>{{$produtoEmEstoque->produto->responsavel->lote}}</td>
                    <td>{{$produtoEmEstoque->produto->responsavel->name}}</td>
                    <td>{{$produtoEmEstoque->produto->produtosEmEstoque->count()}}</td>
                    <td class="d-flex justify-content-center"><i class="fas fa-info"></i></td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
