<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="{{asset('assets/backend/css/admin.css')}}">
    @stack('css')
</head>

<body>
@include('layouts.backend.partial.navbar')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 sidebar collapse" id="sidebar">
         @include('layouts.backend.partial.sidebar')
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-3 col-lg-10 col-lg-offset-2 main">
            @yield('content')
        </div>
    </div>
</div>
<script src='https://code.jquery.com/jquery-3.2.1.slim.min.js'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
<script src="{{asset('assets/backend/js/admin-app.js')}}"></script>
<script>

    setTimeout(function(){
        $('.flashAlert').slideUp(500);
    },3000);
</script>
@stack('js')
</body>
</html>
