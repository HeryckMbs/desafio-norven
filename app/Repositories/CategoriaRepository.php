<?php
namespace App\Repositories;
use App\Http\Requests\CategoriaRequest;
use App\Interfaces\CategoriaRepositoryInterface;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;

class CategoriaRepository implements CategoriaRepositoryInterface{
    private Categoria $categoria;

    public function __construct(Categoria $model){
        $this->categoria = $model;
    }
    public function getIndex(){
        return $this->categoria->index();
    }   

    public function store(CategoriaRequest $request){
        try{
            $imageLink = Storage::putFile('imagensCategoria', $request->url_capa);
            $imageLink = ENV('APP_URL') . '/' . $imageLink;
            Categoria::create([
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'url_capa' => $imageLink
            ]);
        }catch(\Exception $e){
            //LOG
            throw $e;
        }

    }

    public function getProdutosCategoria(int $categoria_id){
        return $this->categoria->findOrFail($categoria_id)->produtos->map->only(['id', 'nome']);
    }

    public function update(CategoriaRequest $request, int $categoria_id){
        try{
            $categoria = $this->categoria->findOrFail($categoria_id);
            $arrayUpdate = [
                'nome' => $request->nome,
                'descricao' => $request->descricao,
            ];
            if (isset($request->url_capa)) {
                $nameOldFile = explode('/', $categoria->url_capa);
                if (Storage::disk('imagensCategoria')->exists(end($nameOldFile))) {
                    Storage::disk('imagensCategoria')->delete(end($nameOldFile));
                }
                $imageLink = Storage::putFile('imagensCategoria', $request->url_capa);
                $imageLink = ENV('APP_URL') . '/' . $imageLink;
                $arrayUpdate['url_capa'] = $imageLink;
            }
    
            $categoria->update($arrayUpdate);
        }catch(\Exception $e){
            throw $e;
        }
    }

    public function destroy(int $categoria_id){
        try{
            return $this->categoria->findOrFail($categoria_id)->delete();
        }catch(\Exception $e){
            throw $e;
        }

    }
}