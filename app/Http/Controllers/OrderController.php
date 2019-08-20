<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(){

        $orders = Order::with('cart')
            ->whereHas('cart', function ($query){
                $query->where('user_id',\auth()->id());
            })
            ->orderByDesc('created_at')
            ->get();
        return view('order', compact('orders'));
    }

    public function detail($id){
        $order = Order::with('cart.cart_products.product')
            ->whereHas('cart', function ($query){
                $query->where('user_id',\auth()->id());
            })
            ->where('orders.id',$id)
            ->firstOrFail();

        return view('orderdetail', compact('order'));
    }
}
