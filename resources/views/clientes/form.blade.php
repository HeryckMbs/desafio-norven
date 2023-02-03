<form id="formCliente" method="POST" action="" enctype="multipart/form-data">


    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <div class="modal-body">

                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Nome</label>
                        <input name="nome" value="" id="nome" placeholder="" type="text"
                            class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>CPF/CNPJ</label>
                        <input id="cpf/cnpj" value="" type="text" class="form-control" name="cpf/cnpj">

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group ">

                        <div class="row">
                            <div class="col-12 form-group">

                                <label for="nascimento">Data de Nascimento</label>
                                <input type="date" name="data_nascimento" class="form-control" id="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 form-group">
                                <label for="nascimento">Telefone 1</label>
                                <input type="text" name="telefone" class="form-control" id="">
                            </div>
                        </div>


                    </div>
                    <div class="col-md-6 form-group">

                        <div class="row">
                            <div class="col-12 form-group">
                                <label>Email</label>
                                <input name="email" value="" id="email" placeholder="" type="email"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 form-group">
                                <label for="nascimento">Telefone 2</label>
                                <input type="text" name="telefone2" class="form-control" id="">
                            </div>
                        </div>


                    </div>

                </div>
             <h4>Endereço</h4>
                <div class="row">
                    <div class="col-6 form-group">
                        <label>Estado</label>
                        <select name="estado" id="estado" class="form-control">
                            @foreach($estados as $estado)
                                <option>{{ $estado->Nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 form-group">
                        <label>Cidade</label>
                        <select name="cidades" id="cidades" class="form-control">
                            
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label>Bairro</label>
                        <select name="bairro" id="bairro" class="form-control">
                        
                        </select>
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

       $('#estado').on('change',function(){
            let estado = $('#estado').val()        
            $.ajax({
                method: "GET",
                url: `http://enderecos.metheora.com/api/estado/${estado}/cidades`
            }).done(function(response){
                $('#cidades').empty()
                response.forEach(function(element){
                    let option = `<option value='${element.Id}'>
                        ${element.Nome}
                        </option>`;
                    $('#cidades').append(option)

                })
            })

       });

       $('#cidades').on('change', function(){
            let cidade = $('#cidades').val()
            console.log(cidade)
            $.ajax({
                method: "get",
                url: `http://enderecos.metheora.com/api/cidade/${cidade}/bairros`
            }).done(function(response){
                $('#bairro').empty()
                response.forEach(function(element){
                    let option = `<option value='${element.Id}'>
                        ${element.Nome}
                        </option>`;
                    $('#bairro').append(option)
                })
            })
       })
        
        </script>
</form>
