@extends('layouts.frontend.master')

@section('title', 'Anasayfa')



@push('css')

@endpush

@section('content')
    <div class="container">
        @include('layouts.frontend.partial.alert')
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Kategoriler</div>
                    <div class="list-group categories">
                        @foreach($categories as $category)
                             <a href="{{route('category',$category->slug)}}" class="list-group-item">
                                 <i class="{{$category->icon}}"></i>
                                 {{$category->name}}
                                 <span class="badge">{{$category->products->count()}}</span>
                             </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @for($i =0; $i < count($product_slider); $i++)
                            <li data-target="#carousel-example-generic" data-slide-to="{{$i}}" class=" {{$i==0 ? "active":""}}" ></li>
                        @endfor

                    </ol>
                    <div class="carousel-inner" role="listbox">
                        @foreach($product_slider as $i => $slider)
                            <div class="item {{$i==0 ? "active":""}}">
                                <img  class="slider-image img-responsive"
                                      src="{{'/uploads/products/'.$slider->product->detail->image}}"
                                      alt="{{$slider->name}}">
                                <div class="carousel-caption">
                                    {{$slider->product->name}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default" id="sidebar-product">
                    <div class="panel-heading">Günün Fırsatı</div>
                    <div class="panel-body">
                        <a href="{{route('product.detail',$product_of_day->slug)}}">
                            <img  class="product-img img-responsive"
                                  src="{{'/uploads/products/'.$product_of_day->detail->image}}"
                                  alt="{{$product_of_day->name}}">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="products">
            <div class="panel panel-theme">
                <div class="panel-heading">Öne Çıkan Ürünler</div>
                <div class="panel-body">
                    <div class="row">
                      @foreach($product_ahead as $i=>$ahead)
                        <div class="col-md-3 product">
                            <a href="{{route('product.detail',$ahead->product->slug)}}">
                                <img  class="product-img img-responsive"
                                      src="{{'/uploads/products/'.$ahead->product->detail->image}}"
                                      alt="{{$ahead->product->name}}">
                            </a>
                            <p><a href="{{route('product.detail',$ahead->product->slug)}}">{{$ahead->product->name}}</a></p>
                            <p class="price">{{$ahead->product->price}}</p>
                            <form action="{{route('add.cart')}}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{$ahead->id}}">
                                <input type="submit" class="btn btn-theme" value="Sepete Ekle">

                            </form>
                        </div>
                     @endforeach
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="products">
            <div class="panel panel-theme">
                <div class="panel-heading">Çok Satan Ürünler</div>
                <div class="panel-body">
                    <div class="row">
                        @foreach($product_best_seller as $i=>$best_seller)
                            <div class="col-md-3 product">
                                <a href="{{route('product.detail',$best_seller->product->slug)}}">
                                    <img  class="product-img img-responsive"
                                          src="{{'/uploads/products/'.$best_seller->product->detail->image}}"
                                          alt="{{$best_seller->product->name}}">
                                </a>
                                <p><a href="{{route('product.detail',$best_seller->product->slug)}}">{{$best_seller->product->name}}</a></p>
                                <p class="price">{{$best_seller->product->price}}</p>
                                <form action="{{route('add.cart')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$best_seller->id}}">
                                    <input type="submit" class="btn btn-theme" value="Sepete Ekle">

                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="products">
            <div class="panel panel-theme">
                <div class="panel-heading">İndirimli Ürünler</div>
                <div class="panel-body">
                    <div class="row">
                        @foreach($product_discounted as $i=>$discounted)

                            <div class="col-md-3 product">
                                <a href="{{route('product.detail',$discounted->product->slug)}}">
                                    <img  class="product-img img-responsive"
                                          src="{{'/uploads/products/'.$discounted->product->detail->image}}"
                                          alt="{{$discounted->product->name}}">
                                </a>
                                <p><a href="{{route('product.detail',$discounted->product->slug)}}">{{$discounted->product->name}}</a></p>
                                <p class="price">{{$discounted->product->price}}</p>
                                <form action="{{route('add.cart')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$discounted
                                    ->id}}">
                                    <input type="submit" class="btn btn-theme" value="Sepete Ekle">

                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>"
@endsection

@push('js')

@endpush

