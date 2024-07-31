<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteContato extends Model
{

    /*
    php artisan tinker
    use \App\Models\SiteContato;

    $contatos=SiteContato::where('id','>',1)->get();
    $contatos=SiteContato::where('motivo_contato','<=',2)->get();
    $contatos=SiteContato::where('nome','<>','Maria')->get();
    $contatos=SiteContato::where('nome','Maria')->get(); ==
    $contatos=SiteContato::where('mensagem','like','%detalhes%')->get();

    $contatos = SiteContato::whereIn('motivo_contato',[1,3])->get();
    $contatos = SiteContato::whereNotIn('motivo_contato',[1,3])->get();
    $contatos = SiteContato::whereBetween('id',[3,6])->get();
    $contatos = SiteContato::whereNotBetween('id',[3,6])->get();
    $contatos = SiteContato::where('nome','<>','Fernando')->whereIn('motivo_contato',[1,2])->whereBetween('created_at',['2020-08-01 00:00:00','2020-08-31 23:59:59'])->get();
    $contatos = SiteContato::where('nome','<>','Fernando')->orWhereIn('motivo_contato',[1,2])->orWhereBetween('created_at',['2020-08-01 00:00:00','2020-08-31 23:59:59'])->get();
    
    $contatos=SiteContato::whereNull('updated_at')->get();
    $contatos=SiteContato::whereNotNull('updated_at')->get();

    $contatos=SiteContato::whereDate('created_at','2020-08-31')->get();
    $contatos=SiteContato::whereDay('created_at','31')->get();
    $contatos=SiteContato::whereMonth('created_at','8')->get();
    $contatos=SiteContato::whereYear('created_at','2020')->get();
    $contatos=SiteContato::whereYear('created_at','2020')->whereDay('created_at','31')->get();
    $contatos=SiteContato::whereTime('created_at','=','22:31:17')->get();

    $contato = SiteContato::whereColumn('created_at','updated_at')->get();
    $contato = SiteContato::whereColumn('created_at','>','updated_at')->get();
    $contato = SiteContato::whereColumn('created_at','<>','updated_at')->get();

    Subgrupos de consultas
    $contatos=SiteContato::where(function($query){ $query->where('nome','Jorge')->orWhere('nome','Ana');})->where(function($query){$query->whereIn('motivo_contato',[1,2])->orWhereBetween('id',[4,6]);})->get();

    Ordenação
    $contatos = SiteContato::orderBy('nome','asc')->get();
    $contatos = SiteContato::orderBy('nome','desc')->get();
    $contatos = SiteContato::orderBy('motivo_contato')->orderBy('nome','desc')->get();
    $contatos = SiteContato::whereBetween('id',[2,6])->orderBy('motivo_contato')->orderBy('nome','desc')->get(); 
    
    COLLECTIONS
    $contatos->first();
    $contatos->last();
    $contatos->reverse();

    SiteContato::all()->toArray();
    SiteContato::all()->toJson();

    SiteContato::all()->pluck('email');
    SiteContato::all()->pluck('email')->first();
    SiteContato::all()->pluck('email')->last();
    SiteContato::all()->pluck('email')->reverse();
    SiteContato::all()->pluck('email')->toArray();
    SiteContato::all()->pluck('email')->tojson();
    SiteContato::all()->pluck('email','nome');


    $fornecedor->nome="Fornecedor 123";
    $fornecedor->save();

    NA CLASSE: protected $fillable=['nome','site','uf','email'];
    $fornecedores2->fill(['nome'=>"Fornecedor 789",'site'=>'fornecedor789.com.br','email'=>'contato@fornecedor789.com.br']);
    $fornecedor->save();
    
    Fornecedor::whereIn('id',[1,2])->update(['nome'=>'Fornecedor Teste','site'=>'teste.com.br']);
    
    DELETE
    use \App\Models\SiteContato;
    $contato = SiteContato::find(4);
    $contato->delete();
    SiteContato::find(7)->delete();
    SiteContato::destroy(5);

    Soft Delete
    
    */
    use HasFactory;
}
