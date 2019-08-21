<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="{{asset('assets/backend/css/login.css')}}">
</head>

<body>
<div class="container">
    @include('layouts.backend.partial.alert')
    <form  action="{{route('admin.login')}}" method="POST" class="form-signin">
        @csrf
        <img src="{{asset('assets/backend/img/logo.png')}}" class="logo">

        <label for="email" class="sr-only">E-Posta</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="E-posta" >
        <label for="password" class="sr-only">Şifre</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Şifre" >
        <div class="checkbox">
            <label>
                <input type="checkbox" name="rememberme" value="1" checked> Beni Hatırla
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Giriş Yap</button>
        <div class="links">
        </div>
    </form>
</div>
<script src='https://code.jquery.com/jquery-3.2.1.slim.min.js'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>

</body>

</html>
