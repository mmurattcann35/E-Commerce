<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $best_seller = DB::select(
            "SELECT p.name, SUM(cp.quantity)
            FROM  orders ord
                INNER JOIN  carts c  ON c.id = ord.cart_id                
                INNER JOIN  cart_product cp ON c.id = cp.cart_id
                INNER JOIN products p  ON p.id = cp.product_id
            GROUP BY p.name
            ORDER BY SUM(cp.quantity) DESC");

        return view('admin.dashboard', compact('best_seller'));
    }
}
