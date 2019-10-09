@extends('layouts.app')
@section('title')
  <title>{{date('Y/m/d', strtotime($commit->limit))}}までの{{count($commit->commitGroups)}}コミット | Commit</title>
@endsection

@section('content')
    @include('error')
  <div id="single">
    <div class="wrap600 ptb40-80">
      <h1><span>{{date('Y/m/d', strtotime($commit->limit))}}</span>までの<span>{{count($commit->commitGroups)}}</span>コミット</h1>

      <div class="time-limit">
        <div class="">
          <span>残り</span><span>{{ $remainingDays }}</span><span>日で</span><span>{{ $remainingCommits }}</span><span>個</span>
        </div>
      </div>

      <div class="shea">
        <a id="twitter" class="shea-btn shea-btn-twitter">
          <i class="fab fa-twitter"></i>
        </a>

        <a id="facebook" class="shea-btn shea-btn-facebook">
          <i class="fab fa-facebook-f"></i>
        </a>
      </div>

      <ol>
      @foreach($commitGroups as $key => $commitGroup)
        @if ($commitGroup->status)
          <li class="complete"><span class="txt">{{ $commitGroup->content }}</span><span class="complete-txt"><span>完了</span></span></li>
        @else
          <li><span>{{ $commitGroup->content }}</span></li>
        @endif
      @endforeach
      </ol>

      <div class="btn-wrap">
        @if (Auth::check() && Auth::id() === $commit->user_id && strtotime($commit->limit) >= strtotime(date("Y-m-d")))
          <a href="{{ route('commits.edit', $commit->id) }}" class="edit-btn">編集する</a>
        @endif
        @if (Auth::check() && Auth::id() === $commit->user_id)
          <a id="{{ $commit->id }}" href="{{ route('home') }}" class="delete-btn delete">削除する</a>
          <input id="token" type="hidden" name="_token" value="{{ csrf_token() }}">
        @endif
      </div>
    </div>
  </div>

@endsection
@section('scripts')
  <script src="//kit.fontawesome.com/dbfcc583ce.js" crossorigin="anonymous"></script>
  @if(app('env') == 'local')
    <script src="{{ asset('js/share.js') }}" defer></script>
    <script src="{{ asset('js/delete.js') }}" defer></script>
  @else
    <script src="{{ secure_asset('js/share.js') }}" defer></script>
    <script src="{{ secure_asset('js/delete.js') }}" defer></script>
  @endif
@endsection