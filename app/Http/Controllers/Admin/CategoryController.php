<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function index(){
        $mainCategories = Category::where('ust_id',null)->orWhere('ust_id',0)->get();

        $categories = Category::with('ust_category')->orderBy('name','asc')->paginate(10)->appends('search',request('search'));

        return view('admin.category.index',compact('categories','mainCategories'));
    }
    public function create(){
        $categories = Category::where('ust_id',null)->orWhere('ust_id',0)->orderBy('name','asc')->get();
        return view('admin.category.create',compact('categories'));
    }
    public function store(Request $request){
        $this->validate($request,[
            'name'      => 'required|unique:categories',
            'icon'      => 'required',
            'slug'      => 'unique:categories'
        ]);

        $data = [
            'name'   => $request->name,
            'icon'   => $request->icon,
            'ust_id' => $request->ust_id == 0 ?  "0":$request->ust_id,
            'slug'   => Str::slug($request->name),
        ];
        $category       = Category::create($data);

        return redirect()->route('admin.category.index')->with('success','Kayıt Başarıyla Eklendi');
    }
    public function edit($id){
        $category = Category::find($id);
        $categories = Category::where('ust_id',null)
            ->orWhere('ust_id',0)
            ->where('name','!=',$category->name)
            ->orderBy('name','asc')->get();

        return view('admin.category.edit',compact('category','categories'));
    }
    public function update($id,Request $request){

        $this->validate($request,[
            'name'      => 'required',
            'icon'     => 'required'
        ]);

        $data = $request->only('name','icon');
        $data['ust_id'] = $request->ust_id == 0 ?  "0":$request->ust_id;
        $category = Category::find($id);
        $category->update($data);


        return redirect()->route('admin.category.index')->with('success','Kayıt Başarıyla Güncellendi');
    }
    public function destroy($id){
        $category = Category::find($id);
        $category->products()->detach();
        $category->delete();
        return redirect()->route('admin.category.index')->with('success','Kayıt Silindi');
    }
    public function search(){
        if(request()->filled('search') || request()->filled('ust_id')){
            request()->flash();
            $search = request('search');
            $ust_id = request('ust_id');
            $categories  = Category::with('ust_category')
                ->where('name','like',"%$search%")
                ->where('ust_id', 'like',"%$ust_id%")
                ->orderBy('name','ASC')
                ->paginate(1)
                ->appends(['search' => $search,'ust_id'=>$ust_id]);
            if($categories->count() <= 0){
                return redirect()->route('admin.category.index')->with('error','Bu aramayla eşleşen bir kayıt bulunamadı');
            }
        }
        $mainCategories = Category::where('ust_id',null)->orWhere('ust_id',0)->get();

        return view('admin.category.index',compact('categories','mainCategories'));
    }

}
