<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{ secure_asset('img/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ secure_asset('img/webclip.png') }}">

    <meta name="author" content="">
    @if(Request::is('home') || Request::is('commits/*/edit'))
      <meta name="robots" content="noindex" />
    @endif
    @if(Request::is('commits/*') && !Request::is('commits/create'))
      <meta name="descpription" content="Commitを使って、【{{date('Y/m/d', strtotime($commit->limit))}}までにやりたい{{count($commit->commitGroups)}}個のこと】に挑戦！">
      <meta property="og:title" content="{{date('Y/m/d', strtotime($commit->limit))}}までの{{count($commit->commitGroups)}}コミット" />
      <meta property="og:description" content="Commitを使って、【{{date('Y/m/d', strtotime($commit->limit))}}までにやりたい{{count($commit->commitGroups)}}個のこと】に挑戦！" />
    @elseif(Request::is('terms'))
      <meta name="descpription" content="Commitの利用規約です。">
      <meta property="og:title" content="Commit" />
      <meta property="og:description" content="Commitは目標、to do、やりたいことなどを共有&管理できるサービスです。" />
    @elseif(Request::is('privacy'))
      <meta name="descpription" content="Commitのプライバシーポリシーです。">
      <meta property="og:title" content="Commit" />
      <meta property="og:description" content="Commitは目標、to do、やりたいことなどを共有&管理できるサービスです。" />
    @else
      <meta name="descpription" content="Commitは目標、to do、やりたいことなどを共有&管理できるサービスです。">
      <meta property="og:title" content="Commit" />
      <meta property="og:description" content="Commitは目標、to do、やりたいことなどを共有&管理できるサービスです。" />
    @endif
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="https://www.commmmit.site/img/og.png" />
    <meta property="og:locale" content="ja_JP" />
    <meta property="og:site_name" content="Commit" />
    <meta property="fb:app_id" content="496204527603841" />
    <meta name="twitter:card" content="summary_large_image" />
    <link rel="icon" href="favicon.ico">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('title')

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

    @if(app('env') != 'local')
      <script async src="https://www.googletagmanager.com/gtag/js?id=UA-145065409-1"></script>
      <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-145065409-1');
      </script>
      <script src="https://cdn.lr-ingest.io/LogRocket.min.js" crossorigin="anonymous"></script>
      <script>window.LogRocket && window.LogRocket.init('rbjwku/commit');</script>
    @endif
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
          <a id="" class="header-link-login" href="{{ route('home') }}" role="button">{{ __('マイページ') }}</a>
          <a class="header-link-logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('ログアウト') }}</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        @endguest
      </div>
    </div>
    </header>
    @yield('content')
    <footer id="footer">
      <ul>
        <li><a href="/terms">利用規約</a></li>
        <li><a href="/privacy">プライバシーポリシー</a></li>
        <li><a id="unsubscribe" href="#" data-id="{{ Auth::id() }}">退会</a></li>
        <li><a href="https://webkore.site/" target="_blank">運営者ブログ</a></li>
      </ul>
      <input id="token" type="hidden" name="_token" value="{{ csrf_token() }}">
      <small>© Copyright <?php echo date('Y'); ?> commmmit.site All rights reserved.</small>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/unsubscribe.js') }}" defer></script>
    @yield('scripts')
</body>
</html>
