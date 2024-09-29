<?php

namespace App\Http\Controllers;

use App\Models\Locacao;
use App\Http\Requests\StoreLocacaoRequest;
use App\Http\Requests\UpdateLocacaoRequest;
use App\Repositories\LocacaoRepository;
use Illuminate\Http\Request;

class LocacaoController extends Controller
{
    protected $locacao;
    public function __construct(Locacao $locacao)
    {
        $this->locacao = $locacao;
    }


    /**php artisan make:model -a Locacao
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $locacaoRepository = new LocacaoRepository($this->locacao);



        if ($request->has('filtro')) {
            $locacaoRepository->filtro($request->filtro);
        };


        if ($request->has('atributos')) {
            $locacaoRepository->selectAtributos($request->atributos);
        }


        return response()->json($locacaoRepository->getResultado(), 200);
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
        $request->validate($this->locacao->rules());


        $locacao = $this->locacao->create([
            'cliente_id' => $request->cliente_id,
            'carro_id' => $request->carro_id,
            'data_inicio_periodo' => $request->data_inicio_periodo,
            'data_final_previsto_periodo' => $request->data_final_previsto_periodo,
            'data_final_realizado_periodo' => $request->data_final_realizado_periodo,
            'valor_diaria' => $request->valor_diaria,
            'km_inicial' => $request->km_inicial,
            'km_final' => $request->km_final,
        ]);



        return response()->json($locacao, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $locacao = $this->locacao->find($id);
        if ($locacao === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        }
        return response()->json($locacao, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Locacao $locacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  int $id)
    {
        $locacao = $this->locacao->find($id);

        if ($locacao === null) {
            return response()->json(['erro' => 'Impossivel realizar a atualização.'], 404);
        }
        if ($request->method() === 'PATCH') {


            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach ($locacao->rules() as $input => $regra) {
                // $teste.='Input: '.$input.' | Regra: '.$regra.'<br>';

                //Coletar as regras parciais
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            // dd($regrasDinamicas);
            $request->validate($regrasDinamicas);
        } else {
            $request->validate($locacao->rules());
        }

        //Remove o arquivo antigo caso o novo arquivo tenha siudo enviado
      

        //preencher o objeto locacao com os dados do request

        $locacao->fill($request->all());
       

        $locacao->save();

        return response()->json($locacao, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $locacao = $this->locacao->find($id);

        if ($locacao === null) {
            return response()->json(['erro' => 'Impossivel realizar a exclusao.'], 404);
        }


        $locacao->delete();
        // $locacao->delete();
        return response()->json(['msg' => 'A locacao foi removida com sucesso!'], 200);
    }
}
