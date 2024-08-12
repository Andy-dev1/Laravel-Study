<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = "produtos";
    protected $fillable = ['nome', 'descricao', 'peso', 'unidade_id'];

    public function itemDetalhe()
    {
        return $this->hasOne('App\Models\ItemDetalhe', 'produto_id', 'id');
    }
    //use App\Models\Produto;
    //Produto::create(["nome"=>"Geladeira","descricao"=>"Geladeira/Refrigerador frost free 350 listros","peso"=>60,"unidade_id"=>1]);
    //Produto::create(["nome"=>"Smart TV","descricao"=>'Smart TV Led 43"',"peso"=>8,"unidade_id"=>1]);

   

    use HasFactory;
}