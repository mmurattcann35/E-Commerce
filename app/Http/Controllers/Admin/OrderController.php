<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\ProductDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;


class OrderController extends Controller
{
    public function index(){
        $orders = Order::with('cart.user')->orderBy('created_at','desc')->paginate(10)->appends('search',request('search'));

        return view('admin.order.index',compact('orders'));
    }
    public function create(){
        $categories = Category::orderBy('name','asc')->get();
        return view('admin.product.create', compact('categories'));
    }
    public function store(Request $request){

        $this->validate($request,[
            'name'      => 'required',
            'price'       => 'required',
            'description' => 'required',
            'image'       => 'required|mimes:jpeg,jpg,png|max:2048'
        ]);
        $categories = $request->categories;
        $data = [
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'price'       => $request->price,
            'description' => $request->description
        ];

        $product       = Product::create($data);

        $image      = $request->file('image');
        $currentDate = Carbon::now()->toDateString();
        $image_name = Str::slug($request->name)."-".$currentDate."-".uniqid().".".$image->getClientOriginalExtension();

        if($image->isValid()){
            $image->move('uploads/products',$image_name);

        }

        $detailData = [
            'image'               => $image_name,
            'show_in_slider'      => $request->has('show_in_slider') ? 1:0,
            'show_product_of_day' => $request->has('show_product_of_day') ? 1:0,
            'show_ahead'          => $request->has('show_ahead') ? 1:0,
            'show_discounted'     => $request->has('show_discounted') ? 1:0,
            'show_best_seller'    => $request->has('show_best_seller') ? 1:0,
        ];


        $product->detail()->create($detailData);
        $product->categories()->attach($categories);
        /*$detailData = $request->only('phone','gsm_phone','address');

        $detailData['product_id'] = $product->id;

        ProductDetail::create($detailData);*/

        return redirect()->route('admin.product.index')->with('success','Kayıt Başarıyla Eklendi');
    }
    public function edit($id){

        $order = Order::with('cart.cart_products.product')->find($id);
        return view('admin.order.edit',compact('order'));
    }
    public function update($id,Request $request){
        $this->validate($request,[
            'name'      => 'required',
            'address'   => 'required',
            'gsm_phone' => 'required',
        ]);

        $data = [
            'user_name'   => $request->name,
            'address'     => $request->address,
            'gsm_phone'   => $request->gsm_phone,
            'phone'       => $request->phone,
            'order_state' => $request->state
        ];
        $order = Order::find($id);
        $order->update($data);

        return redirect()->route('admin.order.index')->with('success','Kayıt Başarıyla Güncellendi');
    }
    public function destroy($id){
        $order = Order::find($id);
        $order->delete();
        return redirect()->route('admin.order.index')->with('success','Kayıt Silindi');
    }
    public function search(){
        \request()->flash();
        $search = request('search');

        $orders  = Order::with('cart.user')
            ->orWhere('id','like',"%$search%")
            ->orderBy('created_at','ASC')
            ->paginate(5)
            ->appends('search',$search);

        return view('admin.order.index',compact('orders','search'));
    }

}
