@extends('layouts.app')
@section('title', 'Marcas')

@section('actions')
    <a href="{{ route('marca.create') }}" class="btn btn-primary">
        Cadastrar marca
    </a>
@endsection


@section('content')

    <div class="d-flex">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <form class="mr-2" id="formSearch" action="{{ route('marca.index') }}" method="GET">
                <input value="{{ $_GET['search'] ?? '' }}" type="text" id="search" name="search" class="form-control"
                    placeholder="" aria-label="" aria-describedby="basic-addon1">
            </form>
            <a href="{{ route('marca.index') }}" class="btn btn-primary">Limpar busca</a>

        </div>
        {{ $marcas->links() }}
    </div>
    @if (!$marcas->isEmpty())
        <table id="marcaTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th class="d-flex justify-content-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($marcas as $marca)
                    <tr class="{{ $marca->deleted_at ? 'bg-danger' : '' }}">
                        <td>{{ $marca->id }}</td>
                        <td>{{ $marca->nome }}</td>

                        <td class="d-flex  justify-content-center">

                            @if ($marca->deleted_at == null)
                                <a href="{{ route('marca.edit', $marca->id) }}" 
                                    class="btn btn-warning  mr-2 "><i class="fas fa-edit"></i></a>
                                <form method="POST" action="{{ route('marca.destroy', $marca->id) }}"
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






@endsection

@push('scripts')
    <script>
        document.getElementById('search').addEventListener('change', function() {
            document.getElementById('formSearch').submit()
        })
    </script>
@endpush
