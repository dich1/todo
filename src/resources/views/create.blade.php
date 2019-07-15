@extends('layout')
@section('title')
  <title>新規作成 | Commit</title>
@endsection
@section('css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.css" rel="stylesheet">
@endsection
@section('header')
  <header id="header" class="">
    <div class="wrap">
      <h1>Commit</h1>
      <div class="header-link">
        <!-- <a href="#" class="header-link-logout">ログアウト</a> -->
        <a href="#" class="header-link-login">ログイン</a>
        <a href="#" class="header-link-registration">新規登録</a>
      </div>
    </div>
  </header>
@endsection

@section('content')
    @include('error')

  <div class="breadcrumb wrap">
    <ul>
      <li><a href="#">マイページ</a></li>
      <li>新規作成</li>
    </ul>
  </div>

  <main id="commit-create">
    <div class="wrap600 ptb40-80">
      <form action="{{ route('commits.store') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group @if($errors->has('user_id')) has-error @endif">
        <input type="hidden" id="user_id-field" name="user_id" class="form-control" value="{{ old("user_id") }}"/>
        <input type="hidden" id="group_id-field" name="group_id" class="form-control" value="{{ old("group_id") }}"/>
           @if($errors->has("group_id"))
            <span class="help-block">{{ $errors->first("group_id") }}</span>
           @endif
        </div>
        <div class="">
          <div class="commit-item-wrap">
            <span class="commit-item">期限</span>
            <div class="form-group @if($errors->has('limit')) has-error @endif">
            <input type="text" id="limit-field" name="limit" class="form-control date-picker" value="{{ old("limit") }}" autocomplete="off"/>
               @if($errors->has("limit"))
                <span class="help-block">{{ $errors->first("limit") }}</span>
               @endif
            </div>
          </div>

          <div class="commit-item-wrap">
            <span class="commit-item">Commit内容</span>
            <p class="attention">※1行に1つ記入してください。</p>
            <div class="">
              <?php for ($i = 0; $i <= 20; $i++) { ?>
                <?php if ($i < 1) { ?>
                    <input type="hidden" name="status[]" value="0">
                    <input type="hidden" name="priority[]" value="<?php echo $i ?>">
                    <div class="form-group @if($errors->has('content')) has-error @endif">
                      <input type="text" id="content-field-<?php echo $i ?>" name="content[]" class="form-control" value="{{ old("content") }}"/>
                      @if($errors->has("content"))
                         <span class="help-block">{{ $errors->first("content") }}</span>
                      @endif
                    </div>
                <?php } else { ?>
                    <input type="hidden" name="status[]" value="0">
                    <input type="hidden" name="priority[]" value="<?php echo $i ?>">
                    <div class="form-group @if($errors->has('content')) has-error @endif">
                      <input type="text" id="content-field-<?php echo $i ?>" name="content[]" class="form-control" value="{{ old("content") }}" style="display: none;" />
                      @if($errors->has("content"))
                        <span class="help-block">{{ $errors->first("content") }}</span>
                      @endif
                    </div>
                <?php } ?>
              <?php } ?>
            </div>
          </div>
        </div>
        <div>
        <input type='button' value='+' id="addForm" class="btn btn-danger">
        <input type="submit" name="" value="この内容で決定">
      </form>
    </div>
  </main>

@endsection
@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script>
  <script>
    $('.date-picker').datepicker({
        format: 'yyyy/mm/dd'
    });

    var addFormCount = 1;
    $('#addForm').click(function(){
      $('#content-field-' + addFormCount).show();
      addFormCount++;
    });
  </script>
@endsection