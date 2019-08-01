<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="descpription" content="〇〇を使って、【2019年12月1日までにやりたい20個のこと】に挑戦中！">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('title')

    <!-- Scripts -->
    @if(app('env') == 'local')
      <script src="{{ asset('js/app.js') }}" defer></script>
    @else
      <script src="{{ secure_asset('js/app.js') }}" defer></script>
    @endif

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @if(app('env') == 'local')
      <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @else
      <link href="{{ secure_asset('css/style.css') }}" rel="stylesheet">
    @endif
    @yield('css')
</head>
<body>
    <header id="header" class="">
    <div class="wrap">
      <h1><a href="/" >Commit</a></h1>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    @yield('scripts')
</body>
</html>
