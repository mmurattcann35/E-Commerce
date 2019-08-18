<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'LARAVEL')</title>
    @include('layouts.frontend.partial.head')
</head>

<body id="commerce">
@include('layouts.frontend.partial.navbar')

@yield('content')

@include('layouts.frontend.partial.footer')

@include('layouts.frontend.partial.script')

</body>

</html>
