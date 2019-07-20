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
              <input type="text" id="limit-field" name="limit" class="form-control date-picker" value="{{ is_null(old("limit")) ? $commit->limit : old("limit") }}" autocomplete="off"/>
              @if($errors->has("limit"))
                <span class="help-block">{{ $errors->first("limit") }}</span>
              @endif
            </div>
          </div>

          <div class="commit-item-wrap">
            <span class="commit-item-add">
              <span>Commit内容</span>
              <span>
                <span class="add">項目を追加</span>
              </span>
            </span>
            <div class="">
              @foreach($commit->commitGroups as $key => $commitGroup)
              <div class="commit-item-bloc">
                <div class="commit-item-bloc-num">
                  <span class="num">{{ $key + 1 }}</span>
                  <div class="">
                    <div class="form-group @if($errors->has('status')) has-error @endif">
                      <input type="hidden" id="status-field-{{ $key }}" name="status[{{ $key }}]" class="form-control" value="{{ is_null(old("status")) ? $commitGroup->status : old("status") }}"/>
                         @if($errors->has("status"))
                          <span class="help-block">{{ $errors->first("status") }}</span>
                         @endif
                    </div>
                    <span class="{{ (!old("status")) ? 'incomplete' : 'complete' }}">{{ (!old("status")) ? '未完了に戻す' : '完了にする' }}</span>
                    <div class="form-group @if($errors->has('priority')) has-error @endif">
                      <input type="hidden" id="priority-field-{{ $key }}" name="priority[{{ $key }}]" class="form-control" value="{{ is_null(old("priority")) ? $commitGroup->priority : old("priority") }}"/>
                        @if($errors->has("priority"))
                          <span class="help-block">{{ $errors->first("priority") }}</span>
                        @endif
                    </div>
                    <span class="move-up">↑</span>
                    <span class="move-down">↓</span>
                    <form action="{{ route('commitGroups.destroy', $commitGroup->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
                      <input type="hidden" name="_method" value="DELETE">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="delete">×</button>
                    </form>
                  </div>
                </div>
                <div class="form-group @if($errors->has('content')) has-error @endif">
                @if ($commit->status)
                <p class="completion-txt"><span>{{ is_null(old("content")) ? $commitGroup->content : old("content") }}</span></p>
                @else
                  <input type="text" id="content-field-{{ $key }}" name="content[]" class="form-control" value="{{ is_null(old("content")) ? $commitGroup->content : old("content") }}"/>
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