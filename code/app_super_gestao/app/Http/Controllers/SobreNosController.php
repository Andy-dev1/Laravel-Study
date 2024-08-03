<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Middleware\LogAcessoMiddleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class SobreNosController extends Controller implements HasMiddleware
{
    // public static function middleware():array
    // {
    //     return[
    //         new Middleware(middleware: LogAcessoMiddleware::class),
    //     ];
    // }
    public static function middleware():array
    {
        return[
            new Middleware(middleware:'log.acesso'),
        ];
    }

    public function sobreNos(){
        return view('site.sobre-nos');
    }
}
