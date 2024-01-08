<?php

namespace App\Repositories;

use App\Http\Requests\MarcaRequest;
use App\Interfaces\MarcaRepositoryInterface;
use App\Models\Marca;

class MarcaRepository implements MarcaRepositoryInterface
{
    private Marca $marca;

    public function __construct(Marca $marca){
        $this->marca = $marca;
    }
    public function getIndex()
    {
        try{
            return $this->marca->index();
        }catch(\Exception $e){
            //LOG
            throw $e;
        }
    }

    public function store(MarcaRequest $request){
        try{
            $this->marca->create($request->except('_token'));
        }catch(\Exception $e){
            //LOG
            throw $e;
        }

    }

    public function update(MarcaRequest $request, int $id){
        try{
            $this->marca->findOrFail($id)->update($request->except(['_token', '_method']));
        }catch(\Exception $e){
            //LOG
            throw $e;
        }
    }

    public function destroy(int $id){
        try{
            $this->marca->findOrFail($id)->delete();
        }catch(\Exception $e){
            //LOG
            throw $e;
        }
    }
}
