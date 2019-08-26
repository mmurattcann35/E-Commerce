@extends('layouts.backend.master')

@section('title','Sipariş Düzenle')

@push('css')
    <style>
        .ck-editor__editable_inline {
            min-height: 200px !important;
        }
    </style>
@endpush

@section('content')
    @include('layouts.backend.partial.validationerrors')
    <form action="{{route('admin.order.update',$order->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="col-md-12">

            <div class="form-group col-md-4">
                <label for="exampleInputEmail1">Ad Soyad</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="{{old('name',$order->cart->user->name)}}" name="name" placeholder="Ad Soyad">
            </div>
            <div class="form-group col-md-4">
                <label for="exampleInputEmail1">Telefon</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="{{old('phone',$order->phone)}}"  name="phone" placeholder="Sabit Telefon">
            </div>
            <div class="form-group col-md-4">
                <label for="exampleInputEmail1">Cep Telefonu</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="{{old('gsm_phone',$order->gsm_phone)}}"  name="gsm_phone" placeholder="Cep Telefonu">
            </div>
            <div class="form-group col-md-8">
                <label for="exampleInputEmail1">Adres</label>
                <textarea  class="form-control" id="exampleInputEmail1"  name="address" rows="6">{{old('gsm_phone',$order->address)}}</textarea>
            </div>
            <div class="form-group col-md-12">
                <label for="state">Sipariş Durumu</label>
                <select name="state" id="state" class="form-control">
                    <option {{old('state',$order->order_state) == "Sipariş Alındı" ? "selected":""}}>Sipariş Alındı</option>
                    <option {{old('state',$order->order_state) == "Ödeme Onaylandı" ? "selected":""}}>Ödeme Onaylandı</option>
                    <option {{old('state',$order->order_state) == "Kargoya Verildi" ? "selected":""}}>Kargoya Verildi</option>
                    <option {{old('state',$order->order_state) == "Sipariş Tamamlandı" ? "selected":""}}>Sipariş Tamamlandı</option>
                </select>
            </div>

        </div>

        <div class="form-group col-md-4 col-md-offset-4">
                <button type="submit" class="btn btn-primary form-control col-md-4">Kaydet</button>
            </div>



    </form>
    <h2>Sipariş (SP-{{$order->id}})</h2>
    <table class="table table-striped table-hover table-responsive">
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
                <td >
                    <a href="{{route('product.detail', ['slug' => $cartProduct->product->slug])}}">
                        <img  class="img-responsive"
                              src="{{'/uploads/products/'.$cartProduct->product->detail->image}}"
                              alt="{{$cartProduct->product->name}}"
                              style="width:100px; height: 80px">
                    </a>
                </td>
                <td>
                    <a href="{{route('product.detail', ['slug' => $cartProduct->product->slug])}}">
                        {{$cartProduct->product->name}}
                    </a>
                </td>
                <td>{{$cartProduct->price}} ₺</td>
                <td>{{$cartProduct->quantity}}</td>
                <td>{{$cartProduct->product->price * $cartProduct->quantity}} ₺</td>
                <td>{{$order->order_state}}</td>
            </tr>
        @endforeach

        </tbody>

        <tfoot>
        <tr>
            <th colspan="2">Sipariş Toplamı</th>
            <th> {{$order->order_price}} ₺</th>
        </tr>
        <tr>
            <th colspan="2" >Toplam Tutar (KDV Dahil)</th>
            <th>{{$order->order_price * ((100 + config('cart.tax'))/100)}} ₺</th>
        </tr>
        <tr>
            <th colspan="2" >Sipariş Durumu</th>
            <th><small>{{$order->order_state}} </small></th>
        </tr>



        </tfoot>
    </table>
@endsection

@push('js')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>

    <script>
        $(function(){
            $('#categories').select2({
                placeholder:"Lütfen Kategori Seçiniz..."
            });


            $("#file").change(function(){
                $("#file_label").html($(this).val().split("\\").splice(-1,1)[0] || "Select file");
            });

        });
    </script>

@endpush

