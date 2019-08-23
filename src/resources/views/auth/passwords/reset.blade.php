@extends('layouts.app')

@section('content')
  <main class="sec mainpage-form-main" id="signup">
    <div class="wrap600">
      <div class="mainpage-form form">
        <h2>パスワード更新</h2>

        <div class="form-wrap">
          <form method="POST" action="{{ route('password.update') }}">
            @csrf
            
            <div class="">
              <input type="hidden" name="token" value="{{ $token }}">
              <div class="form-block">
                <p class="form-bloc-item-name">メールアドレス<span class="required">*</span></p>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="メールアドレスは、aaa@example.com のような形式で記入してください。" required autocomplete="email" autofocus>

                @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong class="error">{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="form-block">
                <p class="form-bloc-item-name">パスワード(8文字以上)<span class="required">*</span></p>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" pattern="^(?=.*?[a-zA-Z])(?=.*?\d)(?=.*?[!-/:-@[-`{-~])[!-~]{8,100}$" title="パスワードは、半角英数字記号をそれぞれ1種類以上含む8文字以上16文字以下で記入してください。" required autocomplete="new-password">

                @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong class="error">{{ $message }}</strong>
                  </span>
                @enderror
              </div>

            <div class="form-block">
              <p class="form-bloc-item-name">パスワード(確認用)<span class="required">*</span></p>
              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="form-submit">
              <input type="submit" name="" value="更新する" class="link">
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