@extends('layouts.app')
@section('title', 'Fornecedores')

@section('actions')
    <a href="{{ route('fornecedor.create') }}" class="btn btn-primary">
        Cadastrar Fornecedor
    </a>
@endsection


@section('content')
    <div class="d-flex">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <form class="mr-2" id="formSearch" action="{{ route('fornecedor.index') }}" method="GET">
                <input value="{{ $_GET['search'] ?? '' }}" type="text" id="search" name="search" class="form-control"
                    placeholder="" aria-label="" aria-describedby="basic-addon1">
            </form>
            <a href="{{ route('fornecedor.index') }}" class="btn btn-primary">Limpar busca</a>
        </div>
        {{ $fornecedores->links() }}
    </div>
    @if (!$fornecedores->isEmpty())
        <table id="fornecedorTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>CNPJ</th>
                    <th>Ativo</th>
                    <th class="d-flex justify-content-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fornecedores as $fornecedor)
                    <tr class="{{ $fornecedor->deleted_at ? 'bg-danger' : '' }}">
                        <td>{{ $fornecedor->id }}</td>
                        <td>{{ $fornecedor->nome }}</td>
                        <td>{{ $fornecedor->cnpj }}</td>
                        <td>{{ $fornecedor->ativo && $fornecedor->deleted_at == null ? 'Ativo' : 'Inativo' }}</td>
                        <td class="d-flex  justify-content-around">
                            @if ($fornecedor->deleted_at == null)
                                <a href="{{ route('fornecedor.edit', $fornecedor->id) }}" type="button"
                                    class="btn btn-warning mr-1 editModal"><i class="fas fa-edit"></i></a>
                                <form method="POST" action="{{ route('fornecedor.destroy', $fornecedor->id) }}"
                                    enctype="multipart/form-data">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>

                                </form>
                            @endif


                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <x-not-found />
    @endif

    <!-- Modal -->
    <div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fotoModalLabel">
                        Foto da fornecedor: <b><span id="nomeFotofornecedor"></span></b>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="">
                        <div class="d-flex justify-content-center">
                            <img src="" id="fotofornecedor" alt="">
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
        document.getElementById('search').addEventListener('change', function() {
            document.getElementById('formSearch').submit()
        })

        $('.infoFoto').on('click', function() {
            $('#fotofornecedor').attr('src', this.dataset.url)
            $('#nomeFotofornecedor').text(this.dataset.nome)
            $('#fotoModal').modal('show')
        })
    </script>
@endpush
