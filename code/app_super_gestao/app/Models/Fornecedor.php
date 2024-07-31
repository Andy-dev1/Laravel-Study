<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fornecedor extends Model
{
    use SoftDeletes;

    protected $table = "fornecedores";//$f->save();
    protected $fillable=['nome','site','uf','email'];
    //\App\Models\Fornecedor::create(['nome'=>"Fornecedor ABC",'site'=>'fornecedorabc.com.br','uf'=>'SP','email'=>'contato@fornecedorabc.com.br']);
    //php artisan tinker
    //     use \App\Models\Fornecedor;
    // > $fornecedores= Fornecedor::all();
    // $fornecedores2 = Fornecedor::find(2)
    // $fornecedores2 = Fornecedor::find([1,2])

    /*
        Soft delete
        $fornecedor->forceDelete();

        Recuperando registros com deletedAt
        Fornecedor::withTrashed()->get();
        Fornecedor::onlyTrashed()->get();
        $fornecedores[0]->restore();
    */
    use HasFactory;
}
