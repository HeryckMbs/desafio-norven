<form id="formCar" method="POST"
    action="{{ isset($carro) ? route('carro.update', $carro->id) : route('carro.create') }}"
    enctype="multipart/form-data">
    @if (isset($carro))
        @method('PUT')
    @endif
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar Carro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <div class="modal-body">

                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Modelo</label>
                        <input value="{{ isset($carro) ? $carro->modelo : '' }} " type="text" class="form-control"
                            id="ModeloCarro" name="modelo">

                    </div>
                    <div class="col-md-6 form-group">
                        <label>Cor</label>
                        <input id="cor" value="{{ isset($carro) ? $carro->cor : '' }} " type="text"
                            class="form-control" name="cor">

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Placa</label>
                        <input id="placa" value="{{ isset($carro) ? $carro->cor : '' }} " type="text"
                            class="form-control" name="placa">

                    </div>
                    <div class="col-md-6 form-group">
                        <label>Kilometragem</label>
                        <input id="kilometragem" value="{{ isset($carro) ? $carro->cor : '' }} " type="number"
                            class="form-control" name="kilometragem">

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Ano</label>
                        <select class="form-control" name="ano">
                            <option value="{{ isset($carro) ? $carro->ano : null }}">
                                {{ isset($carro) ? $carro->ano : 'Selecione um ano' }}</option>
                            @for ($ano = 1920; $ano <= 2022; $ano++)
                                <option value="{{ $ano }}">
                                    {{ $ano }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="Marca">Marca</label>
                        <select id="marca" class="form-control" name="marca">
                            <option value="{{ isset($carro) ? $carro->marca_id : null }}">
                                {{ isset($carro) ? $carro->marca->nome : 'Selecione uma marca' }}</option>
                            @foreach ($marcas as $marca)
                                <option value="{{ $marca->id }}">
                                    {{ $marca->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" id="newMarca" name="newMarca" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Marca não encontrada?</label>
                </div>
                <div class="form-group ">
                    <label for="Modelo">Nova marca</label>
                    <input type="text" disabled class="form-control" id="Modelo" name="marca">
                </div>
                <div class="form-group ">
                    <label for="Modelo">Descrição</label>
                    <textarea id="descricao" class="form-control" rows="3" name="descricao">{{ isset($carro) ? $carro->descricao : '' }}</textarea>
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
