@extends('layouts.app')

@section('content')
  <main class="mainpage-form-main" id="login">
    <div class="wrap600 ptb40-80">
      <div class="mainpage-form form">
        <h2>ログイン</h2>

        <div class="form-wrap">
          <p class="mail-login-txt">メールアドレスでログイン</p>

          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="">
              <div class="form-block">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="form-block">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
            </div>

            <div class="form-submit">
              <button type="submit" class="link btn btn-light">
                {{ __('ログイン') }}
              </button>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                  {{ __('次回からログインしない') }}
                </label>
              </div>
            </div>

            <div class="form-signup">
              <a href="{{ route('register') }}" class="link">新規登録はこちら</a>
            </div>

            <p class="pass-forget">
              @if (Route::has('password.request'))
                  <a class="pass-forget btn btn-link" href="{{ route('password.request') }}">
                      {{ __('パスワードを忘れた方はこちら') }}
                  </a>
              @endif
          </form>
        </div>
      </div>
    </div>
  </main>
@endsection