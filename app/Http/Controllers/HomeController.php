<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $categories     = Category::where('ust_id',null)->orderBy('name','asc')->get()->take(8);
        $product_slider = ProductDetail::with('product')
            ->where('show_in_slider',1)
            ->take(5)
            ->get();
        $product_of_day = Product::select('products.*')->join('product_detail','product_detail.product_id','product_id')
            ->where('product_detail.show_product_of_day',1)
            ->first();
        $product_best_seller = ProductDetail::with('product')
            ->where('show_best_seller',1)
            ->take(4)
            ->get();
        $product_ahead = ProductDetail::with('product')
            ->where('show_ahead',1)
            ->take(4)
            ->get();
        $product_discounted = ProductDetail::with('product')
            ->where('show_discounted',1)
            ->take(4)
            ->get();
        return view('home',compact('categories','product_slider','product_of_day','product_ahead','product_best_seller','product_discounted'));
    }
}
