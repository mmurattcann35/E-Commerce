@extends('layouts.frontend.master')

@section('title','Siparişler')

@push('css')

@endpush

@section('content')
    <div class="container">
        @include('layouts.frontend.partial.alert')
        <div class="bg-content">
            <h2>Siparişler</h2>
            @if($orders->count() <= 0)
                <p class="alert alert-danger">Henüz kayıtlı siparişiniz bulunmamaktadır.</p>
            @else
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Sipariş Kodu</th>
                        <th>Tutar</th>
                        <th>Toplam ürün</th>
                        <th>Durum</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>SP-{{$order->id}}</td>
                        <td>{{$order->order_price * ((100 +config('cart.tax'))/100)}}</td>
                        <td>{{$order->cart->cart_product_count($order->cart->id)}}</td>
                        <td>{{$order->order_state}}</td>
                        <td><a href="{{route('order.detail',$order->id)}}" class="btn btn-sm btn-success">Detay</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
@endsection

@push('js')

@endpush

