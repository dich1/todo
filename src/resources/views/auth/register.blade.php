@extends('layouts.app')
@section('title')
  <title>新規登録 | Commit</title>
@endsection

@section('content')
  <main class="sec mainpage-form-main" id="signup">
    <div class="wrap600">
      <div class="mainpage-form form">
        <h2>新規登録</h2>

        <div class="form-wrap">
          <!-- <div class="sns-login">
            <a href="#" class="twitter-login link">
              <span><i class="fab fa-twitter"></i></span>
              <span>Twitterで登録</span>
            </a>

            <a href="#" class="facebook-login link">
              <span><i class="fab fa-facebook-f"></i></span>
              <span>Facebookで登録</span>
            </a>
          </div> -->

          <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="">
              <div class="form-block">
                <p class="form-bloc-item-name">名前<span class="required">*</span></p>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong class="error">{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="form-block">
                <p class="form-bloc-item-name">メールアドレス<span class="required">*</span></p>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="メールアドレスは、aaa@example.com のような形式で記入してください。" required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong class="error">{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="form-block">
                <p class="form-bloc-item-name">パスワード(8文字以上)<span class="required">*</span></p>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="例:8文字以上" autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong class="error">{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="form-block">
                <p class="form-bloc-item-name">パスワード(確認用)<span class="required">*</span></p>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" oninput="checkPassword(this)" required autocomplete="new-password">
              </div>
            </div>

            <div class="form-consent">
              <label>
                <input type="checkbox" name="" required="" id="">

                <span><a href="#" target="_blank" class="link">利用規約</a>に同意する。</span>
              </label>
            </div>

            <div class="form-submit">
              <input type="submit" name="" value="登録する(無料)" class="link">
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
@endsection
@section('scripts')
  <script>
    function checkPassword(confirm){
        var input1 = document.getElementById('password').value;
        var input2 = confirm.value;
        if(input1 != input2){
            confirm.setCustomValidity("入力値が一致しません。");
        }else{
            confirm.setCustomValidity('');
        }
    }
  </script>
@endsection