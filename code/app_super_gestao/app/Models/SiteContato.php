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
    */
    use HasFactory;
}
