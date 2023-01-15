<form id="formManutencao" method="POST"
    action="{{ isset($carro) ? route('carro.update', $carro->id) : route('manutencao.create') }}"
    enctype="multipart/form-data">
    @if (isset($agendamento))
        @method('PUT')
    @endif
    <div class="modal-dialog modal-default">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar Manutenção</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <div class="modal-body">

                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Carro</label>
                        <select class="form-control" id="carro" name="carro">
                            @foreach ($my_cars as $car)
                                <option value="{{ $car->id }}">
                                    {{ $car->modelo }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col-md-6 form-group">
                        <label>Data de Entrega</label>
                        <input id="data_entrega" value="{{ isset($carro) ? $carro->cor : '' }} " type="date"
                            class="form-control" name="data_entrega">

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group ">
                        <label for="Modelo">Serviços</label>
                        @foreach ($servicos as $servico)
                            <div class="form-check">
                                <input class="form-check-input" name="servico[]" type="checkbox"
                                    value="{{ $servico->id }}" id="flexCheckDefault{{ $loop->iteration }}">
                                <label class="form-check-label" for="flexCheckDefault{{ $loop->iteration }}">
                                    {{ $servico->nome }}
                                </label>
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group ">
                        <label for="Modelo">Status</label>
                        <select id="status" class="form-control" name="status">
                            <option value="pendente">Pendente</option>
                            <option value="andamento">Em andamento</option>
                            <option value="concluido">Concluído</option>
                            <option value="recusado">Recusado</option>
                        </select>

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
