<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TarefaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $id=Auth::user()->id;
        $name=Auth::user()->name;
        $email=Auth::user()->email;
        return "ID: $id | Nome: $name | Email: $email";

        // if(Auth::check()){
        //      $id=Auth::user()->id;
        //      $name=Auth::user()->name;
        //      $email=Auth::user()->email;
        //      return "ID: $id | Nome: $name | Email: $email";
        //  }else{
        //      return 'Você não está logado no sistema!';
        //  }
        // if(auth()->check()){
        //     $id=auth()->user()->id;
        //     $name=auth()->user()->name;
        //     $email=auth()->user()->email;
        //     return "ID: $id | Nome: $name | Email: $email";
        // }else{
        //     return 'Você não está logado no sistema!';
        // }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tarefa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $tarefa = Tarefa::create($request->all());
        return redirect()->route('tarefa.show',['tarefa'=>$tarefa->id]);
        dd($tarefa->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarefa $tarefa)
    {
        dd($tarefa->getAttributes());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarefa $tarefa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarefa $tarefa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarefa $tarefa)
    {
        //
    }
}
