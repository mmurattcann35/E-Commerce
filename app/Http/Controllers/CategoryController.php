<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index($slug){
        $category       = Category::where('slug',$slug)->firstOrFail();

        $sub_categories = Category::where('ust_id',$category->id)->get();
        $products       = null;

        $order  = request('order');
        if($order == "best-sellers"){
            $products = $category->products()
                ->distinct()
                ->join('product_detail','product_detail.product_id','products.id')
                ->orderBy('product_detail.show_best_seller','desc')
                ->paginate(4);

        }elseif($order == "news"){
            $products       = $category->products()->distinct()->orderBy('created_at','desc')->paginate(2);
        }else{
            $products       = $category->products()->distinct()->paginate(4);
        }
        return view('category', compact('category','sub_categories','products'));
    }
}
