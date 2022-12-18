<button onclick="modalG({{ $id }})" type="button" class="btn btn-success"><i class="fas fa-edit"></i></button>
<form method="POST" action="{{ route('carro.delete', $id) }}" enctype="multipart/form-data">
    @method('DELETE')
    @csrf
    <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>

</form>
