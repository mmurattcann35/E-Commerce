@extends('layouts.backend.master')

@section('title','Kullanıcılar')

@push('css')

@endpush

@section('content')
    @include('layouts.backend.partial.alert')
    <h2 class="sub-header">
        Kullanıcılar

        <a href="{{route('admin.user.create')}}" class="btn btn-info  pull-right"><i class="fa fa-plus"></i>  Yeni </a>
    </h2>

    <div class="well">
        <form action="{{route('admin.user.search')}}" method="GET">
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
            <button type="submit" class="btn btn-primary" >Ara</button>
            <a href="{{route('admin.user.index')}}" class="btn btn-default">Temizle</a>
        </form>
        @if(isset($search))
            "{{$search}}" Kelimesine ait arama sonuçları({{$users->total()}})
        @endif
    </div>


    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Tam Adı</th>
                <th>E-Posta</th>
                <th>Rolü</th>
                <th>Durumu</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $i=>$user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            @if($user->is_admin == 1)
                                Admin
                            @else
                                Standart Kullanıcı
                            @endif
                        </td>
                        <td>
                            @if($user->is_active == 1)
                                Aktif
                            @else
                                Bloke Edildi
                            @endif
                        </td>
                        <td>
                            <a href="{{route('admin.user.edit',$user->id)}}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzenle">
                                <span class="fa fa-pencil"></span>
                            </a>

                            <form id="delete-form" action="{{route('admin.user.destroy',$user->id)}}" method="POST" style="display: inline-block;" >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs"><span class="fa fa-trash"></span></button>

                            </form>
                        </td>


                    </tr>
            @endforeach
            </tbody>
        </table>
        {{$users->links()}}
    </div>

@endsection

@push('js')

@endpush

