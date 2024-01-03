@extends('layouts.app')
@section('title', 'Categorias')

@section('actions')
    <a href="{{ route('categoria.create') }}" class="btn btn-primary">
        Cadastrar categoria
    </a>
@endsection


@section('content')
    <div class="d-flex">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <form class="mr-2" id="formSearch" action="{{ route('categoria.index') }}" method="GET">
                <input type="text" id="search" name="search" class="form-control" placeholder="" aria-label=""
                    aria-describedby="basic-addon1">
            </form>
            <a href="{{ route('produto.index') }}" class="btn btn-primary">Limpar busca</a>

        </div>
        {{ $categorias->links() }}
    </div>
    @if (!$categorias->isEmpty())
        <table id="categoriaTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th class="d-flex justify-content-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->id }}</td>
                        <td>{{ $categoria->nome }}</td>
                        <td>{{ $categoria->descricao }}</td>
                        <td class="d-flex  justify-content-around">
                            <button data-url="{{ $categoria->url_capa }}" data-nome="{{ $categoria->nome }}" type="button"
                                class="btn btn-primary infoFoto mr-1">
                                <i class="fas fa-info"></i>
                            </button>
                            <a href="{{ route('categoria.edit', $categoria->id) }}" type="button"
                                class="btn btn-warning mr-1 editModal"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('categoria.destroy', $categoria->id) }}"
                                enctype="multipart/form-data">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>

                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <x-not-found />
    @endif
    <div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fotoModalLabel">
                        Foto da categoria: <b><span id="nomeFotoCategoria"></span></b>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="">
                        <div class="d-flex justify-content-center">
                            <img src="" id="fotoCategoria" alt="">
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
        $('.infoFoto').on('click', function() {
            $('#fotoCategoria').attr('src', this.dataset.url)
            $('#nomeFotoCategoria').text(this.dataset.nome)
            $('#fotoModal').modal('show')
        })
        document.getElementById('search').addEventListener('change', function() {
            document.getElementById('formSearch').submit()
        })
    </script>
@endpush
