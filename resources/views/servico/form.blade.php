<form id="formManutencao" method="POST" action="" enctype="multipart/form-data">
    {{-- @if (isset($carro))
        @method('PUT')
    @endif --}}
    <div class="modal-dialog modal-default">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar Serviço</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <div class="modal-body">
                @csrf
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Nome</label>
                        <input name="nome" value="" type="text" class="form-control">

                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 form-group ">
                        <label for="Modelo">Valor</label>
                        <input name="valor" value="" type="number" class="form-control">
                    </div>
                </div>
                {{-- TODO:: --}}
                {{-- RETIRAR ESSE CAMPO E COLOCAR NA ORDEM DE FECHAMENTO DA MANUTENÇÃO --}}
                <div class="row">
                    <div class="col-md-12 form-group ">
                        <label for="Modelo">Desconto</label>
                        <input name="desconto" min="0" max="100" value="" type="number"
                            class="form-control">

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group ">
                        <label for="Modelo">Descrição</label>
                        <textarea id="descricao" class="form-control" rows="3" name="descricao">{{ isset($carro) ? $carro->descricao : '' }}</textarea>
                    </div>
                </div>


            </div>

            <div class="modal-footer">
                <button type="button" id="fecha" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="enviar"type="submit" class="btn btn-primary">Save changes</button>
            </div>


        </div>


    </div>
    <script>
        $('#fecha').on('click', function() {
            for (input of $('#modalRequest input')) {
                $('#descricao').empty()
                if (input.name != '_token') {
                    input.value = ''
                }
            }
            $('#modalRequest').modal('hide');
        })
    </script>
</form>
