<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        return view('order');
    }

    public function detail($id){
        return view('orderdetail');
    }
}
