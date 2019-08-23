@extends('layouts.backend.master')

@section('title','Ürünler')

@push('css')

@endpush

@section('content')
    @include('layouts.backend.partial.alert')
    <h2 class="sub-header">
        Ürünler
        <a href="{{route('admin.product.create')}}" class="btn btn-info  pull-right"><i class="fa fa-plus"></i>  Yeni </a>
    </h2>

    <div class="well">
        <form action="{{route('admin.product.search')}}" method="GET">
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
            <a href="{{route('admin.product.index')}}" class="btn btn-default">Temizle</a>
        </form>

        @if(isset($search))
            "{{$search}}" Kelimesine ait arama sonuçları({{$products->total()}})
        @endif
    </div>


    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Başlığı</th>
                <th>Slug</th>
                <th>Fiyat</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $i=>$product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->slug}}</td>
                        <td>{{$product->price}}₺</td>
                        <td>
                            <a href="{{route('admin.product.edit',$product->id)}}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzenle">
                                <span class="fa fa-pencil"></span>
                            </a>

                            <form id="delete-form" action="{{route('admin.product.destroy',$product->id)}}" method="POST" style="display: inline-block;" >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs"><span class="fa fa-trash"></span></button>

                            </form>
                        </td>
                    </tr>
            @endforeach
            </tbody>
        </table>
        {{$products->links()}}
    </div>

@endsection

@push('js')

@endpush

