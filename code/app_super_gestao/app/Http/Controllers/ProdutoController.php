<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Produto;

use App\Http\Controllers\Controller;
use App\Models\Fornecedor;
use App\Models\ProdutoDetalhe;
use App\Models\Unidade;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     * php artisan make:controller --resource ProdutoController --model=Produto
     */
    public function index(Request $request)
    {
        //$produtos = Produto::paginate(10);
        //Eager loading
        $produtos = Item::with(['itemDetalhe','fornecedor'])->paginate(10);
        /*
        foreach($produtos as $key => $produto){
            //print_r($produto->getAttributes());
            //echo "<br><br>";

            $produtoDetalhe = ProdutoDetalhe::where('produto_id',$produto->id)->first();
            //Collection ProdutoDetalhe
            if(isset($produtoDetalhe)){
                //print_r($produtoDetalhe->getAttributes());

                $produtos[$key]['comprimento']=$produtoDetalhe->comprimento;
                $produtos[$key]['largura']=$produtoDetalhe->largura;
                $produtos[$key]['altura']=$produtoDetalhe->altura;
            }
            //echo '<hr>';
        }
        */
        return view('app.produto.index', ["produtos" => $produtos, "request" => $request->all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fornecedores= Fornecedor::all();
        $unidades = Unidade::all();

        return view("app.produto.create", ["unidades" => $unidades,"fornecedores"=>$fornecedores]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $regras = [
            'nome' => 'required|min:3|max:40',
            'descricao' => 'required|min:3|max:2000',
            'peso' => 'required|integer',
            'unidade_id' => 'exists:unidades,id',
            'fornecedor_id' => 'exists:fornecedores,id'
        ];
        $feedback = [
            'required'=>'O campo :attribute deve ser preenchido',
            'nome.min'=>'O campo nome deve ter no mínimo 3 caracteres',
            'nome.max'=>'O campo nome deve ter no máximo 40 caracterers',
            'descricao.min'=>'O campo descricao deve ter no mínimo 3 caracteres',
            'descricao.max'=>'O campo descricao deve ter no máximo 2000 caracterers',
            'peso.integer'=>'O campo peso deve ser um número inteiro',
            'unidade_id.exists'=>'A unidade de medida informada não existe',
            'fornecedor_id.exists' => 'O fornecedor informado não existe'
        ];
        $request->validate($regras,$feedback);

        Item::create($request->all());

        return redirect()->route("produto.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        //dd($produto);
        return view("app.produto.show", ["produto" => $produto]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $produto)
    {
        $unidades=Unidade::all();
        $fornecedores= Fornecedor::all();
        return view("app.produto.edit", ["produto" => $produto,'unidades'=>$unidades,"fornecedores"=>$fornecedores]);
        //return view("app.produto.create", ["produto" => $produto,'unidades'=>$unidades]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $produto)
    {
        $regras = [
            'nome' => 'required|min:3|max:40',
            'descricao' => 'required|min:3|max:2000',
            'peso' => 'required|integer',
            'unidade_id' => 'exists:unidades,id',
            'fornecedor_id' => 'exists:fornecedores,id'
        ];
        $feedback = [
            'required'=>'O campo :attribute deve ser preenchido',
            'nome.min'=>'O campo nome deve ter no mínimo 3 caracteres',
            'nome.max'=>'O campo nome deve ter no máximo 40 caracterers',
            'descricao.min'=>'O campo descricao deve ter no mínimo 3 caracteres',
            'descricao.max'=>'O campo descricao deve ter no máximo 2000 caracterers',
            'peso.integer'=>'O campo peso deve ser um número inteiro',
            'unidade_id.exists'=>'A unidade de medida informada não existe',
            'fornecedor_id.exists' => 'O fornecedor informado não existe'
        ];
        $request->validate($regras,$feedback);

        print_r($request->all());//Payload
        echo "<br><br><br>";
        print_r($produto->getAttributes()); //Instancia do objeto antes do payload

        $produto->update($request->all());
        return redirect()->route("produto.show",['produto'=>$produto->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto)
    {
        $produto->delete();
        return redirect()->route("produto.index");
    }
}
