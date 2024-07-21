<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pizza;
use Inertia\Inertia;

class PizzaController extends Controller
{
    public function index(){
        $pizzas= Pizza::all();
        return Inertia::render('Pizzas/All',['pizzas'=>$pizzas]);
    }
}
