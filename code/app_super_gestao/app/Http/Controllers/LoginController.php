<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(Request $request){

        $erro = '';

        if($request->get('erro')==1){
            $erro='Usuário e ou senha não existe';
        }
        return view('site.login',['titulo'=>'Login','erro'=>$erro]);
    }

    public function autenticar(Request $request){
        //regras de validacao
        $regras=[
            'usuario'=>'email',
            'senha'=>'required'
        ];
        //Mensagens de feedback de validação
        $feedback=[
            'usuario.email'=>'O campo usuário (e-mail) é obrigatório',
            'senha.required'=>'O campo senha é obrigatório'
        ];
        $request->validate($regras,$feedback);

        $email=$request->get('usuario');
        $password=$request->get('senha');

        echo "Usuário: $email | Senha: $password";
        echo "<br>";

        //Iniciar o model user
        $user = new User();

        $usuario = $user->where('email',$email)->where('password',$password)->get();
        $usuario = $usuario->first();


        if(isset($usuario->name)){
            echo 'Usuário existe';
        }else{
            return redirect()->route('site.login',['erro'=>1]);
        }

        // echo '<pre>';
        // print_r($usuario);
        // echo '</pre>';
        // print_r($request->all());
    }
}
