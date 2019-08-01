@extends('layout')
@section('title')
  <title>新規作成 | Commit</title>
@endsection
@section('css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.css" rel="stylesheet">
@endsection

@section('content')
    @include('error')

  <div class="breadcrumb wrap">
    <ul>
      <li><a href="{{ route('home') }}">マイページ</a></li>
      <li>新規作成</li>
    </ul>
  </div>

  <main id="commit-create">
    <div class="wrap600 ptb40-80">
      <form id="create" name="create" action="{{ route('commits.store') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group @if($errors->has('user_id')) has-error @endif">
        <input type="hidden" id="user_id-field" name="user_id" class="form-control" value="{{ Auth::id() }}"/>
        <input type="hidden" id="group_id-field" name="group_id" class="form-control" value="1"/>
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
              <textarea id="commit-group" name="content[]" rows="8" cols="80"></textarea>
            </div>
          </div>
        </div>
        <div>
        <input id="submit" type="submit" value="この内容で決定">
      </form>
    </div>
  </main>

@endsection
@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script>
  <script>
    $('.date-picker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose   : true
    });
  </script>
  @if(app('env') == 'local')
    <script src="{{ asset('js/create.js') }}" defer></script>
  @else
    <script src="{{ secure_asset('js/create.js') }}" defer></script>
  @endif
@endsection