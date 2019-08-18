<?php

namespace App\Http\Controllers;


use App\Mail\UserRegistrationMail;
use App\User;
use Illuminate\Http\Request;


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
            return redirect()->intended('/');
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
