@extends('layout')
@section('title')
  <title>2019.12.1までの20コミット | Commit</title>
@endsection
@section('css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.css" rel="stylesheet">
@endsection

@section('content')
  <div id="top">
    <div class="wrap600 ptb40-80">
      <div class="msg">
        <p>Commitは目標、to do、やりたいことなどを<br class="pc">共有&管理できるサービスです。</p>
      </div>

      <div class="top-link">
        <a href="{{ route('register') }}" class="registration">新規登録</a>
        <a href="{{ route('login') }}" class="login">ログイン</a>
      </div>

      <div class="description">
        <ul>
          <li>目標決めてをSNSで宣言する。</li>
          <li>チームでto doを共有する</li>
          <li>自己満で使う</li>
        </ul>
        <p>などなど使い方は自由です。<br>簡単に管理画面でCommitの管理や共有が可能です。</p>
      </div>
    </div>
  </div>
@endsection