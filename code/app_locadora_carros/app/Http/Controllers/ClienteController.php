<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Repositories\ClienteRepository;
use Illuminate\Http\Request;

class ClienteController extends Controller
{

    protected $cliente;
    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }


    /**php artisan make:model -a Cliente
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clienteRepository = new ClienteRepository($this->cliente);

        if ($request->has('filtro')) {
            $clienteRepository->filtro($request->filtro);
        };


        if ($request->has('atributos')) {
            $clienteRepository->selectAtributos($request->atributos);
        }


        return response()->json($clienteRepository->getResultado(), 200);
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->cliente->rules());


        $cliente = $this->cliente->create([
            'nome' => $request->nome,
           
        ]);



        return response()->json($cliente, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $cliente = $this->cliente->find($id);
        if ($cliente === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        }
        return response()->json($cliente, 200);
    }

   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  int $id)
    {
        $cliente = $this->cliente->find($id);

        if ($cliente === null) {
            return response()->json(['erro' => 'Impossivel realizar a atualização.'], 404);
        }
        if ($request->method() === 'PATCH') {


            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach ($cliente->rules() as $input => $regra) {
                // $teste.='Input: '.$input.' | Regra: '.$regra.'<br>';

                //Coletar as regras parciais
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            // dd($regrasDinamicas);
            $request->validate($regrasDinamicas);
        } else {
            $request->validate($cliente->rules());
        }

        //Remove o arquivo antigo caso o novo arquivo tenha siudo enviado
      

        //preencher o objeto cliente com os dados do request

        $cliente->fill($request->all());
       

        $cliente->save();

        return response()->json($cliente, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $cliente = $this->cliente->find($id);

        if ($cliente === null) {
            return response()->json(['erro' => 'Impossivel realizar a exclusao.'], 404);
        }


        $cliente->delete();
        // $cliente->delete();
        return response()->json(['msg' => 'A cliente foi removida com sucesso!'], 200);
    }
}
