@extends('layouts.backend.master')

@section('title','Kategoriler')

@push('css')

@endpush

@section('content')
    @include('layouts.backend.partial.alert')
    <h2 class="sub-header">
        Kullanıcılar

        <a href="{{route('admin.category.create')}}" class="btn btn-info  pull-right"><i class="fa fa-plus"></i>  Yeni </a>
    </h2>
    @if($categories->count() > 0)
    <div class="well">
        <form action="{{route('admin.category.search')}}" method="GET">
            @csrf
            <div class="form-group">
                <label for="search">Ara</label>
                <input type="text"
                       name="search"
                       id="search"
                       class="form-control text-center"
                       placeholder="İsim, E-Posta..."
                       value="{{old('search')}}"
                       style="width:300px">
            </div>
            <div class="form-group">
                <select name="ust_id" class="form-control"  >
                    <option value="0">-- Seçin --</option>
                    @foreach($mainCategories as $mainCategory)
                        <option value="{{$mainCategory->id}}" {{old('ust_id') == $mainCategory->id ? "selected" : ""}}>
                            {{$mainCategory->name}}
                        </option>
                     @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary" >Ara</button>
            <a href="{{route('admin.category.index')}}" class="btn btn-default">Temizle</a>
        </form>
    </div>
    @endif

@if($categories->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Kategori Adı</th>
                <th>Slug</th>
                <th>İkon</th>
                <th>Biçim</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $i=>$category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->name}}</td>
                        <td>{{$category->slug}}</td>
                        <td>
                            <i class="{{$category->icon}}"></i>
                        </td>
                        <td>
                           {{-- @if($category->ust_id == null && $category->ust_id == 0)
                                Üst Kategori
                            @else
                               Alt Kategori
                            @endif--}}
                            {{$category->ust_category->name}}
                        </td>
                        <td>
                            <a href="{{route('admin.category.edit',$category->id)}}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzenle">
                                <span class="fa fa-pencil"></span>
                            </a>

                            <form id="delete-form" action="{{route('admin.category.destroy',$category->id)}}" method="POST" style="display: inline-block;" >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs" ><span class="fa fa-trash"></span></button>

                            </form>
                        </td>


                    </tr>
            @endforeach
            </tbody>
        </table>
        {{$categories->links()}}
    </div>
@else
    <div class="alert alert-info">Henüz herhangi bir kayıt bulunmamaktadır. Eklemek için <a href="{{route('admin.user.create')}}" style="color:orange">buraya</a> tıklayın.</div>
@endif
@endsection

@push('js')

@endpush

