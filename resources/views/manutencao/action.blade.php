<div class="d-flex justify-content-around">
    <button onclick="editManutencao({{ $id }})" type="button" class="btn btn-success"><i
            class="fas fa-edit"></i></button>
    <form method="POST" action="{{ route('manutencao.delete', $id) }}" enctype="multipart/form-data">
        @method('DELETE')
        @csrf
        <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>

    </form>
    <button data-target="#modalServicos" onclick="getServicos({{ $id }})" data-toggle="modal"
        class="btn btn-info"><i class="fas fa-info"></i></button>

</div>
