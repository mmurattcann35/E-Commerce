<?php

namespace App\Http\Controllers;


use App\Models\Order;
use App\Models\UserDetail;
use App\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected function index(){
        if(!auth()->check()){
            return redirect()->route('user.login')->with('error','Ödeme işlemi için oturum açmalısınız.');
        }elseif(Cart::count() <= 0 ){
            return redirect()->route('home')->with('error','Ödeme işlemi için sepetinizde en az 1 ürün bulunmalı.');
        }

        $userDetail = UserDetail::find(Auth::id());
        return view('checkout',compact('userDetail'));

    }
    public function payment(Request $request){
        $order=[
            'cart_id' => session()->get('active_cart_id'),
            'bank'       => "Garanti",
            'installment_number' => 1,
            'order_state'        => 'Siparişiniz Alındı.',
            'order_price'        => Cart::subtotal(),
            'user_name'          => $request->user_name,
            'phone'              => $request->phone,
            'gsm_phone'          => $request->gsm_phone,
            'address'            => $request->address
        ];
        Order::create($order);
        Cart::destroy();
        session()->forget('active_cart_id');

        return redirect()->route('orders')->with('success','Ödemeniz başarılı bir şekilde gerçekleştirildi.');

    }
}

