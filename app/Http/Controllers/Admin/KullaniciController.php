<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KullaniciController extends Controller
{
    public function login(Request $request){
        if(!Auth::check()) {
            if (request()->isMethod('GET')) {
                return view('admin.login');
            }

            if (request()->isMethod('POST')) {

                $this->validate($request, [
                    'email' => 'required|email',
                    'password' => 'required'
                ]);

                $creadentials = [
                    'email' => $request->email,
                    'password' => $request->password,
                    'is_admin' => 1
                ];

                if (Auth::guard('administration')->attempt($creadentials, $request->has('rememberme'))) {
                    return redirect()->route('dashboard');
                } else {
                    return back()->with('error', 'Giriş Hatalı');
                }

            }
        }else{
            return redirect()->route('dashboard');
        }
    }

    public function logout(){
        Auth::guard('administration')->logout();
        request()->session()->flush();
        request()->session()->regenerate();

        return redirect()->route('admin.login');
    }
}






