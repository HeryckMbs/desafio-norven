<form id="formManutencao" method="POST"
    action="{{ isset($manutencao) ? route('manutencao.update', $manutencao->id) : route('manutencao.create') }}"
    enctype="multipart/form-data">
    @if (isset($manutencao))
        @method('PUT')
    @endif
    <div class="modal-dialog modal-lg">
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
                                <option {{isset($manutencao) && $car->id == $manutencao->carro_id ? 'selected' : ''}} value="{{ $car->id }}">{{ $car->modelo }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col-md-6 form-group">
                        <label>Data de Entrega</label>
                        <input id="data_entrega" value="{{ isset($manutencao) ? \Carbon\Carbon::parse($manutencao->data_entrega)->format('Y-m-d') : '' }}" type="date"
                            class="form-control" name="data_entrega">

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group ">
                        <label for="Modelo">Serviços</label>
                        @foreach ($servicos as $servico)
                            <div class="form-check">
                                <input class="form-check-input" name="servico[]" type="checkbox"
                                    value="{{ $servico->id }}" {{isset($manutencao_servicos) && in_array($servico->id,$manutencao_servicos->toArray()) ? 'checked':''}} data-valor="{{ $servico->valor }}"
                                    id="servico{{ $loop->iteration }}">
                                <label class="form-check-label" for="servico{{ $loop->iteration }}">
                                    {{ $servico->nome }} - Valor : R$ {{ $servico->valor }}
                                </label>
                            </div>
                        @endforeach

                    </div>
                    <div class="col-md-6 form-group">
                        <div class="row">
                            <div class="col-12 form-group">
                                <label for="status">Status</label>
                                <select id="status" class="form-control" name="status">
                                    @foreach(\App\Models\Manutencao::STATUS as $key => $status)
                                        <option value="{{$key}}"  {{isset($manutencao) && $manutencao->status == $key ? 'selected' : ''}} >{{$status}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 form-group">
                                <label>Desconto</label>
                                <input name="desconto" value="" id="desconto" placeholder="%" type="text"
                                    class="form-control">
                            </div>
                        </div>

                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12 form-group ">
                        <label>Valor</label>
                        <input readonly name="valor" value="{{isset($manutencao) ? 'R$ ' . number_format($manutencao->valor,2,',','.'): ''}}" id="total" type="text"
                            class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group ">
                        <label for="Modelo">Descrição</label>
                        <textarea id="descricao" class="form-control" rows="3" name="descricao"> {{ isset($manutencao) ? $manutencao->descricao : '' }}</textarea>
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
        function getServicos(id_manutencao) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#servicos').empty();
            $.ajax({
                method: "GET",
                url: `/servicos_manutencao/${id_manutencao}`

            }).done(function(response) {
                console.log(response)
                response.forEach(function(element) {
                    let photo = element.url_foto !== '' ? element.url_foto : 'https://img.freepik.com/fotos-gratis/trabalhador-de-servico-de-carro-muscular-reparando-o-veiculo_146671-19605.jpg?w=2000'
                    console.log(response);
                    let html = `<div class="card" >
                                    <img class="card-img-top"
                                    src="${photo}"
                                    alt="Card image cap">
                                    <div class="card-body">
                                        <h3 class="card-title" style="font-weight: bold;">${element.nome}</h3>
                                        <p class="card-text">Descrição: ${element.descricao}</p>
                                        <p class="card-text">Valor: R$ ${element.valor}</p>
                                    </div>
                                </div>`
                    $('#servicos').append(html)
                })
            })
        }
        function limpaCampos(){
            for (input of $('#modalRequest input')) {
                $('#descricao').empty()
                if (input.name !== '_token') {
                    if(input.type === 'checkbox'){
                        input.removeAttribute('checked');
                    }else{
                        input.value = ''
                    }
                }
            }
            $('#modalRequest').modal('hide');
        }

        $('#fecha').on('click', function() {
            limpaCampos();
            let url = '{{route("manutencao.create")}}';
            $('#formManutencao').attr('action',url);

        })

        $('.close').on('click', function(){
            limpaCampos();
            let url = '{{route("manutencao.create")}}';
            $('#formManutencao').attr('action',url);
        })

        $('.form-check-input').on('click', function() {
            setValorTotal()
        })

        function setValorTotal(getValue) {
            let valor = 0;

            $('.form-check input:checked').each(function(index, element) {
                valor += parseInt(element.dataset.valor);
            })

            if(getValue){
                return valor
            }else{
                $('#total').val(valor.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}))
            }

        }

        $('#desconto').on('keyup', function() {
            let desconto = $('#desconto').val();
            if (desconto == 0 || desconto == '') {
                setValorTotal()
            } else {
                let valorManutencao = setValorTotal(true)
                valorManutencao = valorManutencao - (valorManutencao * (desconto / 100))
                $('#total').val(valorManutencao.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));
            }

        })
    </script>
</form>
