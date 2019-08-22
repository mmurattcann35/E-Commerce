@extends('layouts.backend.master')

@section('title','Kullanıcı Düzenle')

@push('css')

@endpush

@section('content')
   @include('layouts.backend.partial.validationerrors')
    <form action="{{route('admin.user.update',$user->id)}}" method="POST">
        @csrf
        @method('PUT')

        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">Tam Adı</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="{{old('name',$user->name)}}" name="name" placeholder="Ad SOYAD">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">E-Posta</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="{{old('email',$user->email)}}" name="email" placeholder="E-Posta">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Şifre</label>
                <input type="password" class="form-control" id="exampleInputEmail1"  name="password" placeholder="Şifre">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Telefon</label>
                <input type="text" class="form-control" id="exampleInputEmail1"  value="{{old('phone',$user->detail->phone)}}" name="phone" placeholder="Telefon">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Cep Telefonu</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="{{old('gsm_phone',$user->detail->gsm_phone)}}" name="gsm_phone" placeholder="Cep Telefonu">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Adres</label>
                <textarea type="text" class="form-control" name="address" rows="6">{{old('address',$user->detail->address)}}</textarea>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="is_active"{{old('',$user->is_active == 1 ? "checked":"")}}> Aktif
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="is_admin" {{old('',$user->is_admin == 1 ? "checked":"")}}> Admin
                </label>
            </div>
            <div class="form-group col-md-4 col-md-offset-4">
                <button type="submit" class="btn btn-primary form-control col-md-4">Kaydet</button>
            </div>
        </div>
    </form>
@endsection

@push('js')

@endpush

