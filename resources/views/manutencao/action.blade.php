<div class="d-flex justify-content-around">
    <button onclick="editManutencao({{ $id }})" type="button" class="btn btn-success"><i
            class="fas fa-edit"></i></button>
    <form method="POST" action="{{ route('manutencao.delete', $id) }}" enctype="multipart/form-data">
        @method('DELETE')
        @csrf
        <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>

    </form>

</div>
