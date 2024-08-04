<?php

namespace App\Http\Middleware;

use App\Models\LogAcesso;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogAcessoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //Manipular o request
       // return $next($request);
        //dd($request);
        $ip=$request->server->get('REMOTE_ADDR');
        $rota=$request->getRequestUri();
        //response - manipular antes de entregar
        LogAcesso::create(['log'=>"IP $ip requisitou a rota $rota"]);
        //return $next($request);
        // return Response('Chegamos no middleware e finalizamos no proprio middleware');
        $resposta=$next($request);
        $resposta->setStatusCode(200,'O status da resposta e o texto da resposta foram modificados');
       // dd($resposta);
        return $resposta;
    }
}
