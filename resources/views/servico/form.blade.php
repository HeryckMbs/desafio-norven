<form id="formServico" method="POST" action="{{ isset($servico) ? route('servico.update', $servico->id) : route('servico.create') }}"
      enctype="multipart/form-data">
    @if (isset($servico))
        @method('PUT')
    @endif
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
                        <label for="nome">Nome</label>
                        <input name="nome" value="{{isset($servico) ? $servico->nome: ''}}" id="nome" type="text" class="form-control">

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group ">
                        <label for="Modelo">Valor</label>
                        <input name="valor" id="valor" value="{{isset($servico) ? $servico->valor: ''}}" type="number" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group ">
                        <label for="url_foto">Url da Foto</label>
                        <input name="url_foto" id="url_foto" value="{{isset($servico) ? $servico->url_foto: ''}}" type="text"
                            class="form-control">

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group ">
                        <label for="Modelo">Descrição</label>
                        <textarea id="descricao" class="form-control" rows="3" name="descricao">{{ isset($servico) ? $servico->descricao : '' }}</textarea>
                    </div>
                </div>


            </div>

            <div class="modal-footer">
                <button type="button" id="fecha" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button id="enviar" type="submit" class="btn btn-primary">Salvar</button>
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
