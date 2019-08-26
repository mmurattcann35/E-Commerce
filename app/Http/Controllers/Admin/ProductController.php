<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use mysql_xdevapi\Collection;

class ProductController extends Controller
{
    public function index(){
        $products = Product::orderBy('name','asc')->paginate(10)->appends('search',request('search'));
        return  $products;
        return view('admin.product.index',compact('products'));
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
        $categories = Category::orderBy('name','asc')->get();
        $product = Product::with('detail')->find($id);

        $product_categories = $product->categories()->pluck('category_id')->all();

        return view('admin.product.edit',compact('product','categories','product_categories'));
    }
    public function update($id,Request $request){


        $this->validate($request,[
            'name'      => 'required',
            'price'       => 'required',
            'description' => 'required'
        ]);

        $categories = $request->categories;
        $data = [
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'price'       => $request->price,
            'description' => $request->description,
        ];
        $product = Product::find($id);
        $product->update($data);

        $image      = $request->file('image');
        $detailData =[];
        // Update detail data.
        if($request->hasFile('image')) {
            $this->validate($request, ['image' => 'mimes:jpeg,jpeg,png']);

            if($image->isValid()){
                $currentDate = Carbon::now()->toDateString();
                $image_name = Str::slug($request->name)."-".$currentDate."-".uniqid().".".$image->getClientOriginalExtension();
                $image->move('uploads/products',$image_name);
                $detailData = [
                    'image'               => $image_name,
                    'show_in_slider'      => $request->has('show_in_slider') ? 1:0,
                    'show_product_of_day' => $request->has('show_product_of_day') ? 1:0,
                    'show_ahead'          => $request->has('show_ahead') ? 1:0,
                    'show_discounted'     => $request->has('show_discounted') ? 1:0,
                    'show_best_seller'    => $request->has('show_best_seller') ? 1:0,
                ];
            }
        }else{
            $detailData = [
                'image'               => 'default.png',
                'show_in_slider'      => $request->has('show_in_slider') ? 1:0,
                'show_product_of_day' => $request->has('show_product_of_day') ? 1:0,
                'show_ahead'          => $request->has('show_ahead') ? 1:0,
                'show_discounted'     => $request->has('show_discounted') ? 1:0,
                'show_best_seller'    => $request->has('show_best_seller') ? 1:0,
            ];

        }

        $product->detail()->update($detailData);
        $product->categories()->sync($categories);
        return redirect()->route('admin.product.index')->with('success','Kayıt Başarıyla Güncellendi');
    }
    public function destroy($id){
        $product = Product::find($id);
        $product->categories()->detach();
        $productDetail = $product->detail->delete();
        $product->delete();
        return redirect()->route('admin.product.index')->with('success','Kayıt Silindi');
    }
    public function search(){
        \request()->flash();
        $search = request('search');

        $products  = Product::where('name','like',"%$search%")
            ->orWhere('description','like',"%$search%")
            ->orderBy('name','ASC')
            ->paginate(5)
            ->appends('search',$search);

        return view('admin.product.index',compact('products','search'));
    }

}
