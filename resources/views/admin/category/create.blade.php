@extends('layouts.backend.master')

@section('title','Kategori Ekle')

@push('css')

@endpush

@section('content')
    @include('layouts.backend.partial.validationerrors')
    <form action="{{route('admin.category.store')}}" method="POST">
        @csrf

        <div class="col-md-12">
            <div class="form-group">
                <label for="ust_id">Üst Kategoriler </label><br>
                <select name="ust_id" class="form-control"  >
                    <option value="0" >--- Ana Kategori Olarak Ayarla ---</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Kategori Adı</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="{{old('name')}}" name="name" placeholder="Kategori">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">İkonu</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="{{old('icon')}}"  name="icon" placeholder="İkon">
            </div>

            <div class="form-group col-md-4 col-md-offset-4">
                <button type="submit" class="btn btn-primary form-control col-md-4">Kaydet</button>
            </div>

        </div>

    </form>
@endsection

@push('js')

@endpush

