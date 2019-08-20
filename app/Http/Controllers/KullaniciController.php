<?php

namespace App\Http\Controllers;


use App\Mail\UserRegistrationMail;
use App\Models\Cart;
use App\Models\CartProduct;
use App\User;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class KullaniciController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function loginForm(){
        return view('kullanici.loginForm');
    }

    public function registerForm(){
        return view('kullanici.registerForm');
    }
    public function register(Request $request){
        $user = User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'activation_key' => Str::random(60),
            'is_active'      => 0
        ]);

        Mail::to($user->email)->send(new UserRegistrationMail($user));
        auth()->login($user);
        return redirect()->route('home');
    }

    public function activation($activation_key){
        $user = User::where('activation_key', $activation_key)->firstOrFail();

        if(!is_null($user)){
            $user->activation_key = null;
            $user->is_active      = 1;
            $user->save();

            return redirect()->route('home')->with('success','Kaydınız Aktifleşirildi.');
        }else{
            return redirect()->route('home')->with('error','Kullanıcı Kaydı Bulunamadı.');
        }
    }
    public function login(Request $request){
        $this->validate($request,[
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if(auth()->attempt(['email' => $request->email, 'password' => $request->password],$request->has('remember'))){
            $request->session()->regenerate();
            $active_cart_id = Cart::active_cart_id();

            if(Auth::check() && is_null($active_cart_id)){
                $active_cart    = Cart::create(['user_id', auth()->id()]);
                $active_cart_id = $active_cart->id;
            }
            session()->put('active_cart_id',$active_cart_id);

            if(\Gloudemans\Shoppingcart\Facades\Cart::count() > 0)
            {
                foreach (Gloudemans\Shoppingcart\Facades\Cart::content() as $cartItem)
                {
                    CartProduct::updateOrCreate(
                        ['cart_id'    => $active_cart_id,'product_id' => $cartItem->id],
                        ['quantity' => $cartItem->qty, 'price' => $cartItem->price, 'state' => 'Beklemede']
                    );
                }
            }
            \Gloudemans\Shoppingcart\Facades\Cart::destroy();
            $cartProducts = CartProduct::with('product')->where('cart_id',$active_cart_id)->get();

            foreach ($cartProducts as $cartProduct){

                \Gloudemans\Shoppingcart\Facades\Cart::add($cartProduct->product->id,
                        $cartProduct->product->name,
                        $cartProduct->quantity,
                        $cartProduct->price,
                        ['slug' => $cartProduct->product->slug]
                    );
            }

            return redirect()->route('home');
        }else{
            return back()->with('error','Hatalı Giriş!');
        }
    }
    public function logout(){
        auth()->logout();
        request()->session()->flush();
        request()->session()->regenerate();

        return redirect('/');
    }
}
