<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function index()
    {
        // $fornecedores = [
        //     0 => [
        //         'nome' => 'Fornecedor 1',
        //         'status' => 'N',
        //         'cnpj' => '0',
        //         'ddd' => '11',
        //         'telefone' => '0000-0000',
        //     ],
        //     1 => [
        //         'nome' => 'Fornecedor 2',
        //         'status' => 'S',
        //         'cnpj' => null,
        //         'ddd' => '85',
        //         'telefone' => '0000-0000',
        //     ],
        //     2 => [
        //         'nome' => 'Fornecedor 3',
        //         'status' => 'S',
        //         'cnpj' => null,
        //         'ddd' => '32',
        //         'telefone' => '0000-0000',
        //     ]
        // ];


        // // echo isset($fornecedores[1]['cnpj'])?'CNPJ informado':'CNPJ não informado';

        // return view('app.fornecedor.index', compact('fornecedores'));

        return view('app.fornecedor.index');
    }
    public function listar(Request $request)
    {
        // dd($request->all());
        $fornecedores = Fornecedor::with(['produtos'])->where('nome', 'like', '%' . $request->input('nome') . '%')
            ->where('site', 'like', '%' . $request->input('site') . '%')
            ->where('uf', 'like', '%' . $request->input('uf') . '%')
            ->where('email', 'like', '%' . $request->input('email') . '%')
            ->paginate(2);
        
        return view('app.fornecedor.listar',["fornecedores"=>$fornecedores,"request"=>$request->all()]);
    }
    public function adicionar(Request $request)
    {
        $msg = "";
        // print_r($request->all());
        //Inclusão
        if ($request->input('_token') != ''&& $request->input('id')== '') {
            // //Cadastro
            // echo "Cadastro";
            //Validacao dos dados
            $regras = [
                'nome' => 'required|min:3|max:40',
                'site' => 'required',
                'uf' => 'required|min:2|max:2',
                'email' => 'email',
            ];
            $feedback = [
                'required' => 'O campo :attribute deve ser preenchido',
                'nome.min' => 'O campo nome deve ter no mínimo 3 caracteres',
                'nome.max' => 'O campo nome deve ter no máximo 40 caracteres',
                'uf.min' => 'O campo uf deve ter no mínimo 2 caracteres',
                'uf.max' => 'O campo uf deve ter no máximo 2 caracteres',
                'email.email' => 'O campo email não foi preenchido corretamente'
            ];
            $request->validate($regras, $feedback);
            $fornecedor = new Fornecedor();
            $fornecedor->create($request->all());

            $msg = "Cadastro realizado com sucesso";
        }
        //Edição
        if ($request->input('_token') != ''&& $request->input('id')!= '') {
            $fornecedor = Fornecedor::find($request->input('id'));
            $update=$fornecedor->update($request->all());

            if($update){
                $msg= 'Update Realizado com sucesso';
            }else{
                $msg= 'Update Apresentou Problema';
            }

            return redirect()->route('app.fornecedor.editar', ["id"=>$request->input('id'),"msg" => $msg]);
        }

        return view('app.fornecedor.adicionar', ["msg" => $msg]);
    }
    public function editar($id,$msg=''){
        // echo "Chegamos até aqui";
        $fornecedor=Fornecedor::find($id);
        return view('app.fornecedor.adicionar',['fornecedor'=>$fornecedor,'msg'=>$msg]);
    }
    public function excluir($id){
        // echo "Remover o registro de ID $id";
        Fornecedor::find($id)->delete(); //Com soft delete
        //Fornecedor::find($id)->forceDelete() //Irá deletar permanentemente no banco sem o soft delete
        return redirect()->route('app.fornecedor');
    }
}
