<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function index()
{
    $productos = \App\Models\Product::all(); 
    return view('products.index', compact('productos'));
}

}
