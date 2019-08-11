@extends('layouts.app')
@section('title')
  <title>編集 | Commit</title>
@endsection
@section('css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.css" rel="stylesheet">
@endsection

@section('content')



  <div class="breadcrumb wrap">
    <ul>
      <li><a href="{{ route('home') }}">マイページ</a></li>
      <li>編集</li>
    </ul>
  </div>

  <main id="edit">
    <div class="wrap600 ptb40-80">
      <form action="{{ route('commits.update', $commit->id) }}" method="POST">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="">
          <div class="commit-item-wrap">
            <span class="commit-item">期限</span>
            <div class="form-group @if($errors->has('limit')) has-error @endif">
              <input type="text" id="limit-field" name="limit" class="form-control date-picker" value="{{ is_null(old("limit")) ? $commit->limit : old("limit") }}" autocomplete="off" required />
              @if($errors->has("limit"))
                <span class="help-block">{{ $errors->first("limit") }}</span>
              @endif
            </div>
          </div>

          <div class="commit-item-wrap">
            <span class="commit-item-add">
              <span>Commit内容</span>
              <span>
                <span id="add-form" class="add">項目を追加</span>
              </span>
            </span>
            <div class="commits">
              @foreach($commitGroups as $key => $commitGroup)
              <div id="commit-item-bloc-{{ $commitGroup->id }}" class="commit-item-bloc">
                <div class="commit-item-bloc-num">
                  <span class="num">{{ $key + 1 }}</span>
                  <div class="">
                    <div class="form-group @if($errors->has('id')) has-error @endif">
                      <input type="hidden" id="id-field-{{ $commitGroup->id }}" name="commit-group-id[]" class="form-control" value="{{ is_null(old("id")) ? $commitGroup->id : old("id") }}"/>
                         @if($errors->has("id"))
                          <span class="help-block">{{ $errors->first("id") }}</span>
                         @endif
                    </div>
                    <div class="form-group @if($errors->has('status')) has-error @endif">
                      <input type="hidden" id="status-field-{{ $commitGroup->id }}" name="status[]" class="form-control" value="{{ is_null(old("status")[$key]) ? $commitGroup->status : old("status")[$key] }}"/>
                         @if($errors->has("status"))
                          <span class="help-block">{{ $errors->first("status") }}</span>
                         @endif
                    </div>
                    <span class="{{ (!old("status") && ($commitGroup->status)) ? 'incomplete' : 'completion' }}">{{ (!old("status") && ($commitGroup->status)) ? '未完了に戻す' : '完了にする' }}</span>
                    <div class="form-group @if($errors->has('priority')) has-error @endif">
                      <input type="hidden" id="priority-field-{{ $commitGroup->id }}" name="priority[]" class="form-control" value="{{ is_null(old("priority")[$key]) ? $commitGroup->priority : old("priority")[$key] }}"/>
                        @if($errors->has("priority"))
                          <span class="help-block">{{ $errors->first("priority") }}</span>
                        @endif
                    </div>
                    <span class="move-up">↑</span>
                    <span class="move-down">↓</span>
                    <span id="{{ $commitGroup->id }}" class="delete">×</span>
                    <input id="token" type="hidden" name="_token" value="{{ csrf_token() }}">
                  </div>
                </div>
                <div class="form-group @if($errors->has('content')) has-error @endif">
                @if ($commitGroup->status)
                  <p id="content-field-{{ $commitGroup->id }}" class="completion-txt"><span>{{ is_null(old("content")) ? $commitGroup->content : old("content") }}</span></p>
                  <input type="hidden" name="content[]" class="form-control" value="{{ is_null(old("content")[$key]) ? $commitGroup->content : old("content")[$key] }}"/>
                @else
                  <input type="text" id="content-field-{{ $commitGroup->id }}" name="content[]" class="form-control" value="{{ is_null(old("content")[$key]) ? $commitGroup->content : old("content")[$key] }}" required />
                  @if($errors->has("content"))
                    <span class="help-block">{{ $errors->first("content") }}</span>
                  @endif
                @endif
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>

        <input type="submit" name="" value="この内容で決定">
      </form>
    </div>
  </main>

  <a href="{{ route('commits.create') }}" class="create-commit">
    <span>
      <span>Commit</span>
      <span>作成</span>
    </span>
  </a>

@endsection
@section('scripts')
  <script src="{{ asset('js/datepicker.js') }}" defer></script>
  @if(app('env') == 'local')
    <script src="{{ asset('js/edit.js') }}" defer></script>
  @else
    <script src="{{ secure_asset('js/edit.js') }}" defer></script>
  @endif
@endsection