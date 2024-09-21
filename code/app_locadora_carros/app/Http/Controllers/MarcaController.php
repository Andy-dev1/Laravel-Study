<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;


class MarcaController extends Controller
{
    protected $marca;
    public function __construct(Marca $marca)
    {
        $this->marca=$marca;
    }
    /**php artisan make:model --migration --controller --resource Marca

     * Display a listing of the resource.
     */
    public function index()
    {
        //$marcas = Marca::all();
        $marcas=$this->marca->all();
        return $marcas;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$marca=Marca::create($request->all());
        $marca= $this->marca->create($request->all());
        return $marca;
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $marca= $this->marca->find($id);
        if($marca===null){
            return ['erro'=>'Recurso pesquisado não existe'];
        }
        return $marca;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  int $id)
    {
        // print_r($request->all()); //dados atualizados
        // echo '<hr>';
        // print_r($marca->getAttributes()); //dados antigos


        //$marca->update($request->all());

        $marca=$this->marca->find($id);

        if($marca===null){
            return ['erro'=>'Impossivel realizar a atualização.'];
        }
        $marca->update($request->all());
        return $marca;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $marca= $this->marca->find($id);

        if($marca===null){
            return ['erro'=>'Impossivel realizar a exclusao.'];
        }
        $marca->delete();
        // $marca->delete();
        return ['msg'=>'A marca foi removida com sucesso!'];
    }
}
