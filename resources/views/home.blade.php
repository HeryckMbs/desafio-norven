@extends('layouts.app')

@section('content')
    <!-- Main content -->

    <div class="row">
        @foreach ($categorias as $categoria)
            <div class="col-4">
                <div class="card">
                    <img src="{{ $categoria->url_capa }}" class="card-img-top" alt="" style="height: 200px;width:765px">
                    <div class="px-3 py-1 d-flex align-items-start flex-column bd-highlight mb-3" style="height: 200px;">
                      <div class="mb-auto p-2 bd-highlight"><h5 class="card-title">{{ $categoria->nome }}</h5>
                        <p class="card-text">{{ $categoria->descricao }}</p></div>
                      <div class="p-2 bd-highlight"><a href="{{route('categoria.index',$categoria->id)}}" class="btn btn-primary">Acessar produtos</a></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    <!-- /.content -->
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
@endpush
