<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteContato;

class ContatoController extends Controller
{
    public function contato(Request $request){

        // var_dump($_POST);
        //dd($request);
        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // echo $request->input('nome');
        // echo '<br>';
        // echo $request->input('email');
        
        // $contato = new SiteContato();
        // $contato->nome = $request->input('nome');
        // $contato->telefone = $request->input('telefone');
        // $contato->email = $request->input('email');
        // $contato->motivo_contato = $request->input('motivo_contato');
        // $contato->mensagem = $request->input('mensagem');

        // //print_r($contato->getAttributes());
        // $contato->save();
        //$contato = new SiteContato();
        // $contato->fill($request->all());
        //$contato->create($request->all());
        // $contato->save();

        // print_r($contato->getAttributes());

        $motivo_contatos=[
            '1'=>'Dúvida',
            '2'=>'Elogio',
            '3'=>'Reclamação'
        ];

        return view('site.contato',['motivo_contatos'=>$motivo_contatos]);
    }

    public function salvar(Request $request){
        //SiteContato::create($request->all());
        //Realizar a validação dos dados do formulário recebidos no request
        //dd($request);
        $request->validate([
            'nome'=>'required|min:3|max:40', //nomes com no mínimo 3 caracteres e no máximo 40
            'telefone'=>'required',
            'email'=>'required',
            'motivo_contato'=>'required',
            'mensagem'=>'required|max:2000',
        ]);
    }
}
