@extends('layouts.app')
@section('title', 'Lançamentos')

@section('actions')
    <a href="{{ route('lancamento.create') }}" class="btn btn-primary">
        Cadastrar saída
    </a>
@endsection


@section('content')
    <div class="d-flex">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Código do lote

                </span>
            </div>
            <form class="mr-2" id="formSearch" action="{{ route('lancamento.index') }}" method="GET">
                <input type="text" id="search" name="search" class="form-control" placeholder="" aria-label=""
                    aria-describedby="basic-addon1">
            </form>
            <a href="{{ route('lancamento.index') }}" class="btn btn-primary">Limpar busca</a>

        </div>

        {{ $lancamentos->links() }}
    </div>
    @if ($lancamentos->isNotEmpty())
        <table id="produtosTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Lançamento</th>
                    <th>Tipo</th>
                    <th>Código do Lote</th>
                    <th>Nome do produto</th>
                    <th>Quantidade</th>

                    <th>Data de Operação</th>



                </tr>
            </thead>
            <tbody>
                @foreach ($lancamentos as $lancamento)
                    <tr>
                        <td>{{ str_pad($lancamento->id, 4, '0', STR_PAD_LEFT) }}</td>

                        <td>{!! \App\Enums\TipoLancamento::from($lancamento->tipo) == \App\Enums\TipoLancamento::Entrada
                            ? '<span class="bg-success p-1 rounded">Entrada</span>'
                            : '<span class="bg-danger p-1 rounded">Saída</span>' !!}</td>
                        </td>
                        <td>
                            {{ str_pad($lancamento->lote_id, 4, '0', STR_PAD_LEFT) }}
                        </td>
                        <td>
                            {{ $lancamento->lote->produto->nome }}
                        </td>
                        <td>
                            {{ $lancamento->quantidade }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($lancamento->created_at)->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                @endforeach
            <tfoot>


            </tfoot>
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
