<form id="formManutencao" method="POST"
    action="{{ isset($carro) ? route('carro.update', $carro->id) : route('manutencao.create') }}"
    enctype="multipart/form-data">
    @if (isset($carro))
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
                        <select class="form-control" name="carro">
                            @foreach ($my_cars as $car)
                                <option value="{{ $car->id }}">
                                    {{ $car->modelo }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col-md-6 form-group">
                        <label>Data de Entrega</label>
                        <input value="{{ isset($carro) ? $carro->cor : '' }} " type="date" class="form-control"
                            name="data_entrega">

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group ">
                        <label for="Modelo">Serviço</label>
                        <select class="form-control" name="servico">
                            <option>Selecione um serviço</option>
                            <option value="{{ null }}">Serviço não encontrado</option>
                            @if (isset($servicos))
                                @foreach ($servicos as $servico)
                                    <option value="{{ $servicos->id }}">
                                        {{ $servicos->descricao }}</option>
                                @endforeach
                            @endif
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
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>


        </div>


    </div>
    <script>
        $('#fecha').on('click', function() {
            for (input of $('#modalRequest input')) {
                console.log(input)
                $('#descricao').empty()
                if (input.name != '_token') {
                    input.value = ''
                }
            }
            $('#modalRequest').modal('hide');
        })
    </script>
</form>
