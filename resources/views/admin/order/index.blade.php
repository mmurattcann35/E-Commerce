@extends('layouts.backend.master')

@section('title','Siparişler')

@push('css')

@endpush

@section('content')
    @include('layouts.backend.partial.alert')
    <h2 class="sub-header">
       Siparişler
        <a href="{{route('admin.order.create')}}" class="btn btn-info  pull-right"><i class="fa fa-plus"></i>  Yeni </a>
    </h2>

    <div class="well">
        <form action="{{route('admin.order.search')}}" method="GET">
            @csrf
            <div class="form-group">
                <label for="search">Ara</label>
                <input type="text"
                       name="search"
                       id="search"
                       class="form-control text-center"
                       placeholder="Ara..."
                       value="{{old('search')}}"
                       style="width:300px">
            </div>
            <button type="submit" class="btn btn-primary" >Ara</button>
            <a href="{{route('admin.order.index')}}" class="btn btn-default">Temizle</a>
        </form>

        @if(isset($search))
            "{{$search}}" Kelimesine ait arama sonuçları({{$orders->total()}})
        @endif
    </div>


    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Kullanıcı</th>
                <th>Sipariş Kodu</th>
                <th>Tutar</th>
                <th>Durum</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $i=>$order)
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>{{$order->cart->user->name}}</td>
                        <td>SP-{{$order->id}}</td>
                        <td>{{number_format($order->order_price * ((100 + config('cart.tax'))/100),2)}}₺</td>
                        <td>{{$order->order_state}}</td>
                        <td>
                            <a href="{{route('admin.order.edit',$order->id)}}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzenle">
                                <span class="fa fa-pencil"></span>
                            </a>

                            <form id="delete-form" action="{{route('admin.order.destroy',$order->id)}}" method="POST" style="display: inline-block;" >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs"><span class="fa fa-trash"></span></button>

                            </form>
                        </td>
                    </tr>
            @endforeach
            </tbody>
        </table>
        {{$orders->links()}}
    </div>

@endsection

@push('js')

@endpush

