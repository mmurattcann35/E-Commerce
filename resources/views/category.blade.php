@extends('layouts.frontend.master')

@section('title')
    {{$category->name }}
@endsection



@push('css')

@endpush

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}">Anasayfa</a></li>
            <li class="active">{{$category->name}}</li>
        </ol>
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$category->name}}</div>
                    <div class="panel-body">
                        <div class="list-group categories">
                            @foreach($sub_categories as $subCat)
                                <a href="{{route('category',$subCat->slug)}}" class="list-group-item">
                                    <i class="fa fa-television"></i>
                                    {{$subCat->name}}
                                    <span class="badge ">{{$subCat->products->count()}}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">

                <div class="products bg-content">

                    <div style="display:{{$products->count() <= 0 ? "none":"inline-block"}}">
                        Sırala
                        <a href="?order=best-sellers" class="btn btn-default">Çok Satanlar</a>
                        <a href="?order=new" class="btn btn-default">Yeni Ürünler</a>
                    </div>
                    <hr>
                    <div class="row">
                        @if($products->count() > 0)
                            @foreach($products as $product)
                                <div class="col-md-3 product">
                                    <a href="{{route('product.detail',$product->slug)}}">
                                        <img  class="product-image img-responsive"
                                              src="{{'/uploads/products/'.$product->detail->image}}"
                                              alt="{{$product->name}}">
                                    </a>
                                    <p><a href="{{route('product.detail',$product->slug)}}">{{$product->name}}</a></p>
                                    <p class="price">{{$product->price}} ₺</p>
                                    <form action="{{route('add.cart')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                        <input type="submit" class="btn btn-theme" value="Sepete Ekle">

                                    </form>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-danger col-md-6 col-md-offset-2">Bu Kategoriye Ait Ürün Bulunmamaktadır.</div>
                        @endif
                    </div>
                    {{request()->has('order') ? $products->appends(['order' => request('order')])->links() : $products->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush

