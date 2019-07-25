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
                      <input type="hidden" id="status-field-{{ $commitGroup->id }}" name="status[]" class="form-control" value="{{ is_null(old("status")) ? $commitGroup->status : old("status") }}"/>
                         @if($errors->has("status"))
                          <span class="help-block">{{ $errors->first("status") }}</span>
                         @endif
                    </div>
                    <span class="{{ (!old("status") && ($commitGroup->status)) ? 'incomplete' : 'completion' }}">{{ (!old("status") && ($commitGroup->status)) ? '未完了に戻す' : '完了にする' }}</span>
                    <div class="form-group @if($errors->has('priority')) has-error @endif">
                      <input type="hidden" id="priority-field-{{ $commitGroup->id }}" name="priority[]" class="form-control" value="{{ is_null(old("priority")) ? $commitGroup->priority : old("priority") }}"/>
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
                @else
                  <input type="text" id="content-field-{{ $commitGroup->id }}" name="content[]" class="form-control" value="{{ is_null(old("content")) ? $commitGroup->content : old("content") }}"/>
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

    $(document).on('click','.completion', function(){
        changeStatus(this, 1, 'incomplete', '未完了に戻す');
    });

    $(document).on('click','.incomplete', function(){
        changeStatus(this, 0, 'completion', '完了にする');
    });

    $('.delete').click(function(){
        if (!confirm('削除しますか ?')) { 
          return;
        }
        var id = this.id;
        $.ajax({
            type    : 'POST',
            url     : location.protocol + '//' + location.hostname + /commitGroups/ + id,
            dataType: 'text',
            data    : { _token: $('#token').val(), _method: 'DELETE' },
            async   : false,
            timeout : 10000
        }).done(function(data){
            var targetElement = '#commit-item-bloc-' + id;
            $(targetElement).remove();
        }).fail(function(data, textStatus, errorThrown) {
            console.log('エラーステータス：' + data.status);
            console.log('ステータスメッセージ：' + textStatus);
            console.log('エラーメッセージ：' + errorThrown.message);
            alert('通信に失敗しました。');
        });
    });

    function changeStatus(event, value, className, statusText) {
        $(event).removeClass().addClass(className);
        $(event).text(statusText);
        var index = $(event).prev().children().attr('id').split('-').pop();
        var contentId = '#content-field-' + index;
        var content = (value === 1) ? $(contentId).val() : $(contentId).children().text();
        var contentParent = $(contentId).parent();
        contentParent.empty();
        var appendText = (value === 1) 
                       ? '<p id="content-field-' + index + '" class="completion-txt"><span>' + content + '</span></p>' 
                       : '<input type="text" id="content-field-' + index + '" name="content[]" class="form-control" value="' + content + '"/>';
        contentParent.append(appendText);
        var statusId = '#status-field-' + index;
        $(statusId).val(value);
    }

    document.addEventListener('DOMContentLoaded', function(){
        var cards = document.querySelectorAll('.commit-item-bloc');
         
        var swapCards = function(card1, card2){
            var duration = 300;
 
            if(!card2 || !card2.classList.contains('commit-item-bloc')) return;
 
            var orgDuration1 = card1.style.transitionDuration;
            var orgDuration2 = card2.style.transitionDuration;
 
            card1.style.transitionDuration = duration + 'ms';
            card2.style.transitionDuration = duration + 'ms';
 
            var diff = card2.offsetTop - card1.offsetTop;
 
            if(diff > 0){
                var spacing = card2.offsetTop - (card1.offsetTop + card1.offsetHeight);
                card1.style.transform = "translateY(" + (card2.offsetHeight + spacing) + "px)";
                replaceNextAttribute(card1);
                card2.style.transform = "translateY(" + (-diff) + "px)";
                replacePreviousAttribute(card2);
            } else {
                var spacing = card1.offsetTop - (card2.offsetTop + card2.offsetHeight);
                card1.style.transform = "translateY(" + (diff) + "px)";
                replacePreviousAttribute(card1);
                card2.style.transform = "translateY(" + (card1.offsetHeight + spacing) + "px)";
                replaceNextAttribute(card2);
            }
            setTimeout(function(){
                card1.style.transitionDuration = orgDuration1;
                card2.style.transitionDuration = orgDuration2;
                card1.style.transform = "translateY(0)";
                card2.style.transform = "translateY(0)";
 
                if(diff < 0){
                    card1.parentNode.insertBefore(card1, card2);
                } else {
                    card1.parentNode.insertBefore(card2, card1);
                }
            }, duration);
        };

        var replaceNextAttribute = function(card) {
            var indexNumber = Number(card.querySelector('.num').innerText) - 1;
            var currentIndexString = String(indexNumber);
            var nextIndexString = String(Number(indexNumber) + 1);
            card.querySelector("input[name='priority[]']").value = nextIndexString;
            card.querySelector('.num').innerText = String(Number(card.querySelector('.num').innerText) + 1);
        };

        var replacePreviousAttribute = function(card) {
            var indexNumber = Number(card.querySelector('.num').innerText) - 1;
            var currentIndexString = String(indexNumber);
            var previousIndexString = String(Number(indexNumber) - 1);
            card.querySelector("input[name='priority[]']").value = previousIndexString;
            card.querySelector('.num').innerText = String(Number(card.querySelector('.num').innerText) - 1);
        };
 
        cards.forEach(function(card){
            card.querySelector(".move-up").addEventListener('click', function(){
                swapCards(card, card.previousElementSibling);
            });
            card.querySelector(".move-down").addEventListener('click', function(){
                swapCards(card, card.nextElementSibling);
            });
        });
    });
  </script>
@endsection