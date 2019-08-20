@extends('layouts.frontend.master')

@section('title','Sepet')

@push('css')

@endpush

@section('content')
    <div class="container">
        @include('layouts.frontend.partial.alert')
        <div class="bg-content">
            <h2>Sepet</h2>
            @if(count(Cart::content())>0)
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Ürün</th>
                    <th>Ürün Adı</th>
                    <th>Adet Fiyatı</th>
                    <th>Adet</th>
                    <th>Tutar</th>
                    <th>İşlem</th>
                </tr>
                </thead>
                <tbody>
                @foreach(Cart::content() as $i => $cartItem )
                    <tr>
                        <td> <img src="http://lorempixel.com/60/60/food/{{$i++}}" alt="{{$cartItem->name}}"></td>
                        <td>
                            <a href="{{route('product.detail',Str::slug($cartItem->name))}}">
                                {{$cartItem->name}}</td>
                            </a>
                        <td>{{$cartItem->price}}</td>
                        <td>
                            <a href="#"
                               class="btn btn-xs btn-default decrease-product-quantity"
                               data-id="{{$cartItem->rowId}}"
                               data-quantity="{{$cartItem->qty-1}}">-</a>
                            <span style="padding: 10px 20px">{{$cartItem->qty}}</span>
                            <a href="#"
                               class="btn btn-xs btn-default  increase-product-quantity"
                               data-id="{{$cartItem->rowId}}"
                               data-quantity="{{$cartItem->qty+1}}">+</a>
                        </td>
                        <td>{{$cartItem->subtotal}}</td>
                        <td>
                            <form action="{{route('remove.cart',['rowId' => $cartItem->rowId])}}" method="POST">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                                    <input type="hidden"  name="product_id" value="{{$cartItem->id}}">
                                    <button type="submit" class="btn btn-danger">Sil</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                    <tr>
                        <th colspan="4">Alt Toplam</th>
                        <th>{{Cart::subtotal()}}</th>
                    </tr>
                    <tr>
                        <th colspan="4">KDV</th>
                        <th>{{Cart::tax()}}</th>
                    </tr>
                    <tr>
                        <th colspan="4">Toplam Tutar (KDV Dahil)</th>
                        <th>{{Cart::total()}}</th>
                    </tr>

                </tbody>
            </table>
            <div>

                <form action="{{route('truncate.cart')}}" method="POST">
                    {{csrf_field()}}
                    @method('DELETE')
                        <button type="submit"  class="btn btn-info pull-left">Sepeti Boşalt</button>
                </form>
                <a href="{{route('checkout')}}" class="btn btn-success pull-right btn-lg">Ödeme Yap</a>
            </div>
            @else
                <div class="alert alert-danger">
                    <p>Sepetinizde ürün bulunmamaktadır.</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('js')
<script>
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.increase-product-quantity, .decrease-product-quantity').on('click', function () {
        var id = $(this).attr('data-id');
        var quantity =$(this).attr('data-quantity');

        $.ajax({
            type:'PATCH',
            url:'cart/update/'+id,
            data:{quantity:quantity},
            success: function (result) {
                window.location.href ='/cart';
            }
        });
    });
</script>
@endpush

