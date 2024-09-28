<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Repositories\ModeloRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{
    protected $modelo;

    public function __construct(Modelo $modelo)
    {
        $this->modelo = $modelo;
    }

    /**php artisan make:model -mcr Modelo
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $modeloRepository = new ModeloRepository($this->modelo);

        if ($request->has('atributos_marca')) {
            $atributos_marca = 'marca:id,' . $request->get('atributos_marca');


            $modeloRepository->selectAtributosRegistrosRelacionados( $atributos_marca);
        } else {


            $modeloRepository->selectAtributosRegistrosRelacionados('marca');
        }

        if ($request->has('filtro')) {

            $modeloRepository->filtro($request->filtro);
        };


        if ($request->has('atributos')) {


            $modeloRepository->selectAtributos($request->atributos);
        }

        // //dd($request->get('atributos'));
        // $modelos=array();
        // if($request->has('atributos_marca')){
        //     $atributos_marca=$request->get('atributos_marca');
        //     $modelos=$this->modelo->with('marca:id,'.$atributos_marca);

        // }else{
        //     $modelos=$this->modelo->with('marca');
        // }

        // if($request->has('filtro')){
        //     //localhost:8000/api/modelo?atributos=id,nome,marca_id&atributos_marca=nome&filtro=abs:=:0;nome:like:Ford%;numero_portas:=:4
        //     //localhost:8000/api/modelo?atributos=id,nome,marca_id,numero_portas,abs&atributos_marca=nome&filtro=nome:like:%Sedan%;numero_portas:=:4;abs:=:1
        //     $filtros=explode(';',$request->filtro);
        //     foreach($filtros as $key=>$condicao){
        //         $c=explode(':',$condicao);
        //         $modelos=$modelos->where($c[0],$c[1],$c[2]);
        //     }
            
        // }

        // if($request->has('atributos')){
        //     $atributos=$request->get('atributos');
            
        //     // $atributos=explode(',',$atributos);
            
        //     $modelos=$modelos->selectRaw($atributos)->get();

        // }else{
        //     $modelos=$modelos->get();
        // }
        // //$this->modelo->with('marca')->get()
        return response()->json($modeloRepository->getResultado(), 200);
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
        $request->validate($this->modelo->rules());
        //stateless
        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens/modelos', 'public');
        //dd($imagem_urn);
        //dd($request->imagem);
        

        $modelo = $this->modelo->create([
            'marca_id' => $request->marca_id,
            'nome' => $request->nome,
            'imagem' => $imagem_urn,
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs,

        ]);

        // $modelo->nome=$request->nome;
        // $modelo->imagem=$imagem_urn;
        // $modelo->save();

        return response()->json($modelo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $modelo = $this->modelo->with('marca')->find($id);
        if ($modelo === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        }
        return response()->json($modelo, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modelo $modelo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        // print_r($request->all()); //dados atualizados
        // echo '<hr>';
        // print_r($marca->getAttributes()); //dados antigos


        //$marca->update($request->all());

        $modelo = $this->modelo->find($id);

        if ($modelo === null) {
            return response()->json(['erro' => 'Impossivel realizar a atualização.'], 404);
        }
        if ($request->method() === 'PATCH') {


            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach ($modelo->rules() as $input => $regra) {
                // $teste.='Input: '.$input.' | Regra: '.$regra.'<br>';

                //Coletar as regras parciais
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            // dd($regrasDinamicas);
            $request->validate($regrasDinamicas);
        } else {
            $request->validate($modelo->rules());
        }

        //Remove o arquivo antigo caso o novo arquivo tenha siudo enviado
        if ($request->file('imagem')) {
            Storage::disk('public')->delete($modelo->imagem);
        }

        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens/modelos', 'public');

        $modelo->fill($request->all());
        $modelo->imagem=$imagem_urn;
        $modelo->save();
        // $modelo->update([
        //     'marca_id' => $request->marca_id,
        //     'nome' => $request->nome,
        //     'imagem' => $imagem_urn,
        //     'numero_portas' => $request->numero_portas,
        //     'lugares' => $request->lugares,
        //     'air_bag' => $request->air_bag,
        //     'abs' => $request->abs,

        // ]);


        return response()->json($modelo, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $modelo = $this->modelo->find($id);

        if ($modelo === null) {
            return response()->json(['erro' => 'Impossivel realizar a exclusao.'],404);
        }

         //Remove o arquivo antigo caso o novo arquivo tenha siudo enviado
         
        Storage::disk('public')->delete($modelo->imagem);
        

        $modelo->delete();
        // $marca->delete();
        return response()->json(['msg' => 'O modelo foi removida com sucesso!'],200);
    }
}
