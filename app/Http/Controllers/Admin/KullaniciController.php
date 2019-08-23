<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserDetail;
use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class KullaniciController extends Controller
{
    public function index(){
        $users = User::orderBy('name','asc')->paginate(10)->appends('search',request('search'));

        return view('admin.user.index',compact('users'));
    }
    public function create(){
        return view('admin.user.create');
    }
    public function store(Request $request){
        $this->validate($request,[
            'name'      => 'required',
            'email'     => 'required|email',
            'gsm_phone' => 'required',
            'address'   => 'required'
        ]);

        $data = [
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'activation_key' => Str::random(10),
            'is_active'      => $request->has('is_active') ? 1 : 0,
            'is_admin'       => $request->has('is_active') ? 1 : 0
        ];
        $user       = User::create($data);
        $detailData = $request->only('phone','gsm_phone','address');

        $detailData['user_id'] = $user->id;

        UserDetail::create($detailData);

        return redirect()->route('admin.user.index')->with('success','Kayıt Başarıyla Eklendi');
    }
    public function edit($id){
        $user = User::find($id);

        return view('admin.user.edit',compact('user'));
    }
    public function update($id,Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email'     => 'required|email',
            'gsm_phone' => 'required',
            'address'   => 'required'
        ]);

        $data = $request->only('email','name');
        if($request->filled('password')){
            $data['password'] =  Hash::make($request->password);
        }
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['is_admin'] = $request->has('is_admin') ? 1 : 0;
        $user = User::find($id);
        $user->update($data);

        // Store detail data.

        $detailData =$request->only('phone','gsm_phone','address');

        UserDetail::updateOrCreate(['user_id' => $id],$detailData);

        return redirect()->route('admin.user.index')->with('success','Kayıt Başarıyla Güncellendi');
    }
    public function destroy($id){
        $user = User::find($id);
        $userDetail = $user->detail->delete();

        $user->delete();
        return redirect()->route('admin.user.index')->with('success','Kayıt Silindi');
    }
    public function search(){
        \request()->flash();
        $search = request('search');

        $users  = User::where('name','like',"%$search%")
            ->orWhere('email','like','%$search%')
            ->orderBy('name','ASC')
            ->paginate(5);
        return view('admin.user.index',compact('users','search'));
    }

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
                    'is_admin' => 1,
                    'is_active' => 1
                ];

                if (Auth::guard('administration')->attempt($creadentials, $request->has('rememberme'))) {
                    return redirect()->route('admin.dashboard');
                } else {
                    return back()->with('error', 'Giriş Hatalı');
                }

            }
        }else{
            return redirect()->route('admin.dashboard');
        }
    }

    public function logout(){
        Auth::guard('administration')->logout();
        request()->session()->flush();
        request()->session()->regenerate();

        return redirect()->route('admin.login');
    }


}






