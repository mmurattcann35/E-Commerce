@extends('layouts.frontend.master')

@section('title')
    {{$searchWord}} Aramasına İlişkin Sonuçlar
@endsection



@push('css')

@endpush

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}">Anasayfa</a></li>
        </ol>
        <div class="row">

            <div class="col-md-12">

                <div class="products bg-content">

                    <div class="text-center">
                        {{$searchWord}} Aramasına ilişkin sonuçlar: <br>
                        Toplam ({{$product_count}})</span>
                    </div>
                    <hr>
                    <div class="row">
                        @if($products->count() > 0)
                            @foreach($products as $i => $product)
                                <div class="col-md-4 product">
                                    <a href="{{route('product.detail',$product->slug)}}"><img src="http://lorempixel.com/400/400/food/{{$i+1}}" alt="{{$product->name}}"></a>
                                    <p><a href="{{route('product.detail',$product->slug)}}">{{$product->name}}</a></p>
                                    <p class="price">{{$product->price}} ₺</p>
                                    <p><a href="#" class="btn btn-theme">Sepete Ekle</a></p>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-danger col-md-6 col-md-offset-2">Aramanızla eşleşen bir ürün bulunmamaktadır.</div>
                        @endif
                    </div>
                    <hr>
                    {{$products->appends(['searchWord' => old('searchWord')])->links()}}
                </div>

            </div>
        </div>
    </div>

@endsection

@push('js')

@endpush

