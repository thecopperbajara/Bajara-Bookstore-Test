<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    
    public function index()
    {
        return view('home');
    }

    function fetchCategory(){
        $categories = Category::all();
        return response()->json($categories);
    }

    function fetchProducts(){
        $products = Product::all();
        return ProductResource::collection($products);
    }
}
