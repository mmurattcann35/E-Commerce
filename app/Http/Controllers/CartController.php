<?php

namespace App\Http\Controllers;

use App\Models\CartProduct;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(){
        return view('cart');
    }
    public function addToCart(Request $request){
        $product  = Product::find($request->product_id);
        $cartItem = Cart::add($product->id,$product->name,1,$product->price);

        if(Auth::check()){
            $active_cart_id = session('active_cart_id');
            if(!isset($active_cart_id)){
                $active_cart = \App\Models\Cart::create([
                     'user_id' => Auth::id()
                ]);
                $active_cart_id = $active_cart->id;
                session()->put('active_cart_id', $active_cart_id);
            }

            CartProduct::updateOrCreate([
                'cart_id'    => $active_cart_id,
                'product_id' => $product->id,
                'quantity'   => $cartItem->qty,
                'price'      => $product->price,
                'state'      => 'Beklemede'
            ]);
        }
        return redirect()->back()->with('success','Ürün sepete başarıyla eklendi');
    }
    public function destroy($rowId){

        if(auth()->check()){
            $active_cart_id = session()->get('active_cart_id');
            $cartItem = Cart::get($rowId);

            $cartProduct = CartProduct::with('product')
                ->where('cart_id',$active_cart_id)
                ->where('product_id',request('product_id'))
                ->first();
            $cartProduct->delete();
        }
        Cart::remove($cartItem);
        return redirect()->back()->with('success','Ürün sepetinizden başarıyla kaldırıldı.');
    }
    public function truncateCart(){
        if(auth()->check()){
            $active_cart_id = session('active_cart_id');
            CartProduct::where('cart_id',$active_cart_id)->delete();
        }
        Cart::destroy();
        return redirect()->back()->with('success','Sepetiniz başarıyla boşaltıldı.');
    }
    public function update($rowId){

        Cart::update($rowId, request('quantity'));
        if(auth()->check()){
            $active_cart_id = session('active_cart_id');
            $cartItem = Cart::get($rowId);

            if(request('quantity') == 0)
                CartProduct::where('cart_id',$active_cart_id)->where('product_id',$cartItem->id)->delete();
            else
                CartProduct::where('cart_id',$active_cart_id)
                    ->where('product_id')
                    ->update(['quantity' => request('quantity')]);
        }
        session()->flash('success','Adet bilgisi güncellendi.');
        return response()->json(['success' => true]);
    }
}
