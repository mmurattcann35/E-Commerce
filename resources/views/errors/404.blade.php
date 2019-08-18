@extends('layouts.frontend.master')

@section('title','404 - Aradığınız Sayfa Bulunamadı')

@push('css')

@endpush

@section('content')

    <div class="container">
        <div class="jumbotron  text-center">
            <h1>404</h1>
            <h2> Aradığınız Sayfa Bulunamadı. </h2>
            <a href="{{route('home')}}" class="btn btn-primary">Anasayfa'ya Dön</a>
        </div>
    </div>

@endsection

@push('js')

@endpush

