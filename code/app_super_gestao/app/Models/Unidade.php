<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    protected $fillable=['unidade','descricao'];
    //php artisan tinker
    //use App\Models\Unidade;
    //Unidade::create(["unidade"=>"UN","descricao"=>"unidade"]);
    use HasFactory;
}
