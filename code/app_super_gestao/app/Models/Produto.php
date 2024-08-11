<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable=['nome','descricao','peso','unidade_id'];

    public function produtoDetalhe(){
        return $this->hasOne('App\Models\ProdutoDetalhe');
    }
    //use App\Models\Produto;
    //Produto::create(["nome"=>"Geladeira","descricao"=>"Geladeira/Refrigerador frost free 350 listros","peso"=>60,"unidade_id"=>1]);
    //Produto::create(["nome"=>"Smart TV","descricao"=>'Smart TV Led 43"',"peso"=>8,"unidade_id"=>1]);
    use HasFactory;
}
