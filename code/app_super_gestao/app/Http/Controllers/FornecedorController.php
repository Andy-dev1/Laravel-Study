<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function index()
    {
        $fornecedores = ['Fornecedor 1','Fornecedor 2'];
        return view('app.fornecedor.index',compact('fornecedores'));
    }
}
