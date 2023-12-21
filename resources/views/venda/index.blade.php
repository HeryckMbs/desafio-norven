@extends('layouts.app')
@section('title', 'Venda de produtos')



@section('content')
    <div class="row">
        <div class="col-3">
            <label for="exampleInputEmail1" class="form-label">Código do produto</label>
            <input name="codigoProduto" value="" class="form-control" id="codigoProduto">


        </div>
        <div class="col-9">
            <table id="categoriaTable" class="table table-striped table-hover rounded">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Descrição</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>3</td>
                        <td>dfsfdfdsdfsfsd</td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        // document.getElementById('imageCategoria').addEventListener('change', function(event) {
        //     let output = document.getElementById('previewImage');
        //     output.src = URL.createObjectURL(event.target.files[0]);
        //     output.onload = function() {
        //         URL.revokeObjectURL(output.src) // free memory
        //     }
        // })
    </script>


@endsection
