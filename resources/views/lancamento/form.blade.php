@extends('layouts.app')
@section('title', isset($produto) ?: 'Cadastrar saída de produtos')


@section('content')
    <form enctype="multipart/form-data" action="{{ route('lancamento.store') }}" method="POST">
        @csrf
        @if (isset($produto))
            @method('PUT')
        @endif
        <div class="row">
            <div class="col-3">
                <label for="exampleInputEmail1" class="form-label">Código do produto</label>
                <input type="number" value="" class="form-control" id="codigoProduto">
                <div class="mt-1">
                    <label for="exampleInputEmail1" class="form-label">Responsável</label>
                    <input name="responsavel" class="form-control" id="responsavel" disabled
                        value="{{ Auth::user()->name }}">

                </div>
                <button type="submit" class="btn btn-primary mt-3">Salvar</button>

            </div>
            <div class="col-9">
                <label for="exampleInputEmail1" class="form-label">Lista de saída</label> 
                @error('produtosSaida')
                    <span class="mt-1  text-red p-1 rounded"><small>{{ $message }}</small></span>
                @enderror
                <input type="hidden" id="produtosSaida" name="produtosSaida">
                <table id="produtosTable" class="table table-striped table-hover rounded">
                    <thead>
                        <tr>
                            <th>Código do produto</th>
                            <th class="text-center">Nome</th>
                            <th class="text-center">Ação</th>


                        </tr>
                    </thead>
                    <tbody>


                    </tbody>
                </table>
            </div>

        </div>






    </form>


    <script>
        // document.getElementById('imageCategoria').addEventListener('change', function(event) {
        //     let output = document.getElementById('previewImage');
        //     output.src = URL.createObjectURL(event.target.files[0]);
        //     output.onload = function() {
        //         URL.revokeObjectURL(output.src) // free memory
        //     }
        // })

        function killMe(element, id) {
            element.parentNode.remove()
            products = products.filter((element, index) => {
                return element != id
            })
        }
        let products = [];
        document.getElementById('codigoProduto').addEventListener('change', function() {
            if (!products.includes(this.value)) {
                fetch(`/getProduto/${this.value}`).then(async (response) => {
                    let result = await response.json();
                    console.log(result)
                    const nextRow = `<tr>
                                        <td>${result.data.id}</td>
                                        <td class="text-center">${result.data.nome} </td>
                                        <td class="text-right" onclick="killMe(this,${result.data.id})"><div class="btn btn-ganger"><i class="fa fa-trash"></i></div></td>
                                    </tr>`;
                    $('#produtosTable tbody').append(nextRow)
                    this.value = ''
                })
                products.push(this.value)
                document.getElementById('produtosSaida').value = products
            } else {
                Toast.fire({
                    heightAuto: true,
                    icon: 'warning',
                    title: 'Ops! Este produto já foi inserido na lista de produtos'
                });
            }
        })
    </script>
@endsection
