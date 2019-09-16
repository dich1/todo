@extends('layouts.app')
@section('title')
  <title>新しいパスワード発行 | Commit</title>
@endsection

@section('content')
  <main class="sec mainpage-form-main" id="password_reset">
    <div class="wrap600">
      <div class="mainpage-form form">
        <h2>新しいパスワード発行</h2>

        <div class="form-wrap">
          @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
          @endif
          
          <p class="password_reset-txt">登録しているメールアドレスを入力してください。新しいパスワードを作成するためのリンクをメールでお送りします。</p>

          <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="">
              <div class="form-block">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="メールアドレスは、aaa@example.com のような形式で記入してください。" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong class="error">{{ $message }}</strong>
                    </span>
                @enderror
              </div>
            </div>

            <div class="form-submit">
              <input type="submit" name="" value="新しいパスワードを発行" class="link">
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
@endsection