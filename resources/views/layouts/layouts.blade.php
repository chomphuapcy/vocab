<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="theme-color" content="#f7668b">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>@yield('title')</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        #main-vocab {
            margin-bottom: 65px;
        }

    </style>
</head>

<body>
    @yield('content')
    <nav class="nav">
        <a href="./" class="nav__link {{ (request()->routeIs('home')) ? 'nav__link--active' : '' }}">
            <i class="material-icons nav__icon">home</i>
            <span class="nav__text">Home</span>
        </a>
        <a href="{{ route("favorite") }}" class="nav__link {{ (request()->routeIs('favorite')) ? 'nav__link--active' : '' }}">
            <i class="material-icons nav__icon">favorite</i>
            <span class="nav__text">Favorite</span>
        </a>
        <a href="{{ route("flash") }}" class="nav__link {{ (request()->routeIs('flash')) ? 'nav__link--active' : '' }}">
            <i class="material-icons nav__icon">spellcheck</i>
            <span class="nav__text">Flash Card</span>
        </a>
        <a href="manage" class="nav__link {{ (request()->routeIs('manage')) ? 'nav__link--active' : '' }}">
            <i class="material-icons nav__icon">mode_edit</i>
            <span class="nav__text">Manage</span>
        </a>
    </nav>
    {{-- <script src="{{ mix('js/app.js') }}" defer></script> --}}
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
    @yield('script')
</body>
</html>
