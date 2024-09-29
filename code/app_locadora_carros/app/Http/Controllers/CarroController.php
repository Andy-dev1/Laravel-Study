<?php

namespace App\Http\Controllers;

use App\Models\Carro;

use App\Http\Requests\UpdateCarroRequest;
use App\Repositories\CarroRepository;
use Illuminate\Http\Request;


class CarroController extends Controller
{
    protected $carro;
    public function __construct(Carro $carro)
    {
        $this->carro = $carro;
    }

    /**php artisan make:model --all Carro           
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $carroRepository = new CarroRepository($this->carro);

        if ($request->has('atributos_modelo')) {
            $atributos_modelo = 'modelo:id,' . $request->get('atributos_modelo');
            $carroRepository->selectAtributosRegistrosRelacionados($atributos_modelo);
        } else {
            $carroRepository->selectAtributosRegistrosRelacionados('modelo');
        }

        if ($request->has('filtro')) {
            $carroRepository->filtro($request->filtro);
        };


        if ($request->has('atributos')) {
            $carroRepository->selectAtributos($request->atributos);
        }


        return response()->json($carroRepository->getResultado(), 200);
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
        $request->validate($this->carro->rules());


        $carro = $this->carro->create([
            'modelo_id' => $request->modelo_id,
            'placa' => $request->placa,
            'disponivel' => $request->disponivel,
            'km' => $request->km,
        ]);



        return response()->json($carro, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $carro = $this->carro->with('modelo')->find($id);
        if ($carro === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        }
        return response()->json($carro, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carro $carro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  int $id)
    {
        $carro = $this->carro->find($id);

        if ($carro === null) {
            return response()->json(['erro' => 'Impossivel realizar a atualização.'], 404);
        }
        if ($request->method() === 'PATCH') {


            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach ($carro->rules() as $input => $regra) {
                // $teste.='Input: '.$input.' | Regra: '.$regra.'<br>';

                //Coletar as regras parciais
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            // dd($regrasDinamicas);
            $request->validate($regrasDinamicas);
        } else {
            $request->validate($carro->rules());
        }

        //Remove o arquivo antigo caso o novo arquivo tenha siudo enviado
      

        //preencher o objeto carro com os dados do request

        $carro->fill($request->all());
       

        $carro->save();

        return response()->json($carro, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $carro = $this->carro->find($id);

        if ($carro === null) {
            return response()->json(['erro' => 'Impossivel realizar a exclusao.'], 404);
        }


        $carro->delete();
        // $carro->delete();
        return response()->json(['msg' => 'A carro foi removida com sucesso!'], 200);
    }
}
