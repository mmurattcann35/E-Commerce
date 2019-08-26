@extends('layouts.frontend.master')

@section('title','Sipariş Detayları')

@push('css')

@endpush

@section('content')
    <div class="container">
        <div class="bg-content">
            <h2>Sipariş (SP-{{$order->id}})</h2>
            <table class="table table-bordererd table-hover">
                <thead>
                    <tr>
                        <th>Ürün</th>
                        <th>Ürün Adı</th>
                        <th>Tutar</th>
                        <th>Adet</th>
                        <th>Ara Toplam</th>
                        <th>Durum</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($order->cart->cart_products as $cartProduct)
                    <tr>
                        <td width="250">
                            <a href="{{route('product.detail', ['slug' => $cartProduct->product->slug])}}">
                                <img  class="cart-image img-responsive"
                                      src="{{'/uploads/products/'.$cartProduct->product->detail->image}}"
                                      alt="{{$cartProduct->product->name}}">
                            </a>
                        </td>
                        <td>
                            <a href="{{route('product.detail', ['slug' => $cartProduct->product->slug])}}">
                                {{$cartProduct->product->name}}
                            </a>
                        </td>
                        <td>{{$cartProduct->price}} ₺</td>
                        <td>{{$cartProduct->quantity}}</td>
                        <td>{{$cartProduct->price * $cartProduct->quantity}} ₺</td>
                        <td>{{$order->order_state}}</td>
                    </tr>
                @endforeach
                    <tr>
                        <th colspan="2"  >Sipariş Toplamı</th>
                        <th> {{$order->order_price}}</th>
                    </tr>
                    <tr>
                        <th colspan="2" >Toplam Tutar (KDV Dahil)</th>
                        <th>{{$order->order_price * ((100 + config('cart.tax'))/100)}} ₺</th>
                    </tr>
                    <tr>
                        <th colspan="2" >Sipariş Durumu</th>
                        <th><small>{{$order->order_state}} </small></th>
                    </tr>


                </tbody>

                <tfoot>
                <tr></tr><tr></tr>

                </tfoot>
            </table>
        </div>
    </div>
@endsection

@push('js')

@endpush

