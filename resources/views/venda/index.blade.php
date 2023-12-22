@extends('layouts.app')
@section('title', 'Venda de produtos')



@section('content')
    <div class="row">
        <div class="col-3">
            <label for="exampleInputEmail1" class="form-label">Código do produto</label>
            <input type="number" name="codigoProduto" value="" class="form-control" id="codigoProduto">


        </div>
        <div class="col-9">
            <table id="produtosTable" class="table table-striped table-hover rounded">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th class="text-center">Descrição</th>
                        <th class="text-center">Valor</th>

                        <th class="text-right">Ação</th>

                    </tr>
                </thead>
                <tbody>
                  
                    
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

        function killMe(element){
            element.parentNode.remove()
        }

        document.getElementById('codigoProduto').addEventListener('change',function(){
            console.log(this.value)
            fetch(`/getInfoProdutoEstoqueVenda/${this.value}`).then(async (response) => {
                    let result = await response.json();
                    const nextRowNumber = document.querySelectorAll('#produtosTable tbody tr').length + 1;
                    const nextRow = `<tr>
                                            <td>${nextRowNumber}</td>
                                            <td class="text-center">${result.data.id} - ${result.data.produto_relacionado.nome} </td>
                                            <td class="text-center">R$${result.data.preco_venda}</td>
                                            <td class="text-right" onclick="killMe(this)"><div class="btn btn-ganger"><i class="fa fa-trash"></i></div></td>
                                    </tr>`;
                    $('#produtosTable tbody').append(nextRow)
                    this.value = ''
            })
        })
    </script>


@endsection
