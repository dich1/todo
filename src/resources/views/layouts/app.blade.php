<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ログイン | Commit</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <header id="header" class="">
    <div class="wrap">
      <h1>Commit</h1>
      <div class="header-link">
        @guest
          <a class="header-link-login" href="{{ route('login') }}">{{ __('ログイン') }}</a>
          @if (Route::has('register'))
            <a class="header-link-registration" href="{{ route('register') }}">{{ __('新規登録') }}</a>
          @endif
        @else
          <a id="" class="" href="{{ route('home') }}" role="button">
            {{ Auth::user()->name }}
          </a>
          <a class="header-link-logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('ログアウト') }}</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        @endguest
      </div>
    </div>
    </header>
    @yield('content')
    <footer id="footer" class="wrap">
        <small>© Copyright 2019 All rights reserved.</small>
    </footer>
</body>
</html>
