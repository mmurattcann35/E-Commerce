<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    use SoftDeletes;

    protected  $table    = 'carts';
    protected  $guarded  = ['id'];

    public function order(){
        return $this->hasOne('App\Models\Order');
    }
    public function cart_products(){
        return $this->hasMany('App\Models\CartProduct');
    }
    public static function  active_cart_id(){
        $active_cart = DB::table('carts as c')
            ->leftJoin('orders as or','or.cart_id','=','c.id')
            ->where('c.user_id',Auth::id())
            ->whereRaw('or.id is null')
            ->orderByDesc('c.created_at')
            ->select('c.id')
            ->first();

        if(!is_null($active_cart)) return $active_cart->id;
    }

    public function cart_product_count(){
        return DB::table('cart_product')->where('cart_id',$this->id)->sum('quantity');
    }
}
