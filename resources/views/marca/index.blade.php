@extends('layouts.app')
@section('title', 'marcas')

@section('actions')
    <a href="{{ route('marca.create') }}" class="btn btn-primary">
        Cadastrar marca
    </a>
@endsection


@section('content')

    <table class="table table-striped table-hover">
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

                    <td class="d-flex  justify-content-around">

                        @if ($marca->deleted_at == null)
                            <a href="{{ route('marca.edit', $marca->id) }}" type="button"
                                class="btn btn-warning mr-1 "><i class="fas fa-edit"></i></a>
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
    <!-- Button trigger modal -->


 

    </div>



@endsection

@push('scripts')

@endpush
