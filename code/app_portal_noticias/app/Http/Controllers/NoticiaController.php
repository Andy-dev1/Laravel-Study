<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Http\Requests\StoreNoticiaRequest;
use App\Http\Requests\UpdateNoticiaRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class NoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $noticias=[];
        

        if(Redis::exists('dez_primeiras_noticias')){
            $noticias=Redis::get('dez_primeiras_noticias');
            $noticias=json_decode($noticias);
        }else{
            $noticias=Noticia::orderByDesc('created_at')->limit(10)->get();

            Redis::set('dez_primeiras_noticias',$noticias);
            Redis::expire('dez_primeiras_noticias',10);
        }
        
        
       

        //criar um dados dentro do bd Redis
        //Redis::set('site','jorge.net');
        
        //chave,valor, tempo em segundos para exprirar o dado em memória
        //echo Redis::get('site');

        return view('noticia',['noticias'=> $noticias]);
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
    public function store(StoreNoticiaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Noticia $noticia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Noticia $noticia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNoticiaRequest $request, Noticia $noticia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Noticia $noticia)
    {
        //
    }
}
