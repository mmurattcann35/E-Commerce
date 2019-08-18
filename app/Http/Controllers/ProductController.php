<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($slug){
        $product = Product::where('slug',$slug)->firstOrFail();

        return view('product', compact('product'));
    }
    public function search(Request $request){
        $searchWord = $request->searchWord;
        $product_count = Product::where('name','like',"%$searchWord%")->count();
        $products = Product::where('name','like',"%$searchWord%")
            ->orWhere('description','like',"%$searchWord%")
            ->paginate(3);

        request()->flash();
        return view('search',compact('products','searchWord','product_count'));
    }
}
