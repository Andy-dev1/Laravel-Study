<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Marca;
use App\Repositories\MarcaRepository;
use Illuminate\Http\Request;


class MarcaController extends Controller
{
    protected $marca;
    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }
    /**php artisan make:model --migration --controller --resource Marca

     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $marcaRepository = new MarcaRepository($this->marca);

        if ($request->has('atributos_modelos')) {
            $atributos_modelos = 'modelos:id,' . $request->get('atributos_modelos');


            $marcaRepository->selectAtributosRegistrosRelacionados($atributos_modelos);
        } else {


            $marcaRepository->selectAtributosRegistrosRelacionados('modelos');
        }

        if ($request->has('filtro')) {

            $marcaRepository->filtro($request->filtro);
        };


        if ($request->has('atributos')) {


            $marcaRepository->selectAtributos($request->atributos);
        }


        //----------------------------------------------------------
        // $marcas = array();

        // if ($request->has('atributos_modelos')) {
        //     $atributos_modelos = $request->get('atributos_modelos');
        //     $marcas = $this->marca->with('modelos:id,' . $atributos_modelos);
        // } else {
        //     $marcas = $this->marca->with('modelos');
        // }

        // if ($request->has('filtro')) {
        //     //localhost:8000/api/modelo?atributos=id,nome,marca_id&atributos_marca=nome&filtro=abs:=:0;nome:like:Ford%;numero_portas:=:4
        //     //localhost:8000/api/modelo?atributos=id,nome,marca_id,numero_portas,abs&atributos_marca=nome&filtro=nome:like:%Sedan%;numero_portas:=:4;abs:=:1
        //     $filtros = explode(';', $request->filtro);
        //     foreach ($filtros as $key => $condicao) {
        //         $c = explode(':', $condicao);
        //         $marcas = $marcas->where($c[0], $c[1], $c[2]);
        //     }
        // }

        // if ($request->has('atributos')) {
        //     $atributos = $request->get('atributos');

        //     // $atributos=explode(',',$atributos);

        //     $marcas = $marcas->selectRaw($atributos)->get();
        // } else {
        //     $marcas = $marcas->get();
        // }

        //$marcas = Marca::all();
        //$marcas = $this->marca->with('modelos')->get();
        //return response()->json($marcas, 200);
        return response()->json($marcaRepository->getResultadoPaginado(3), 200);
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
        //nome
        //imagem


        $request->validate($this->marca->rules(), $this->marca->feedback());
        //stateless
        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens', 'public');
        //dd($imagem_urn);
        //dd($request->imagem);
        $marca = $this->marca->create([
            'nome' => $request->nome,
            'imagem' => $imagem_urn
        ]);

        // $marca->nome=$request->nome;
        // $marca->imagem=$imagem_urn;
        // $marca->save();

        return response()->json($marca, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $marca = $this->marca->with('modelos')->find($id);
        if ($marca === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        }
        return response()->json($marca, 200);
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

        $marca = $this->marca->find($id);

        if ($marca === null) {
            return response()->json(['erro' => 'Impossivel realizar a atualização.'], 404);
        }
        if ($request->method() === 'PATCH') {


            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach ($marca->rules() as $input => $regra) {
                // $teste.='Input: '.$input.' | Regra: '.$regra.'<br>';

                //Coletar as regras parciais
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            // dd($regrasDinamicas);
            $request->validate($regrasDinamicas, $marca->feedback());
        } else {
            $request->validate($marca->rules(), $marca->feedback());
        }

        //Remove o arquivo antigo caso o novo arquivo tenha siudo enviado
       

        //preenchendo o objeto marca com todos os dados do request
        $marca->fill($request->all());

        //Se a imagem foi encaminhada na requisição
        if($request->file('imagem')){
            Storage::disk('public')->delete($marca->imagem);

            $imagem         =    $request->file('imagem');
            $imagem_urn     =    $imagem->store('imagens','public');
            $marca->imagem  =    $imagem_urn;
        }

        $marca->save();

        // $imagem = $request->file('imagem');
        // $imagem_urn = $imagem->store('imagens', 'public');

        // //preencher o objeto marca com os dados do request

        // $marca->fill($request->all());
        // $marca->imagem = $imagem_urn;

        // $marca->save();

        // // $marca->update([
        // //     'nome'=>$request->nome,
        // //     'imagem'=>$imagem_urn
        // // ]);


        return response()->json($marca, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $marca = $this->marca->find($id);

        if ($marca === null) {
            return response()->json(['erro' => 'Impossivel realizar a exclusao.'], 404);
        }

        //Remove o arquivo antigo caso o novo arquivo tenha siudo enviado

        Storage::disk('public')->delete($marca->imagem);


        $marca->delete();
        // $marca->delete();
        return response()->json(['msg' => 'A marca foi removida com sucesso!'], 200);
    }
}
