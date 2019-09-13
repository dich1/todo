@extends('layouts.app')
@section('title')
  <title>{{$commit->limit}}までの{{count($commit->commitGroups)}}コミット | Commit</title>
@endsection
@section('css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.css" rel="stylesheet">
@endsection

@section('content')
    @include('error')
  <div id="single">
    <div class="wrap600 ptb40-80">
      <h1>{{$commit->limit}}までの{{count($commit->commitGroups)}}コミット</h1>

      <div class="time-limit">
        <div class="">
          <span>残り</span><span>{{ $remainingDays }}</span><span>日で</span><span>{{ $remainingCommits }}</span><span>個</span>
        </div>
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

    </div>
  </div>

  <div id="copy" data-clipboard-text="{{ url()->current() }}">コピーする</div>
  <a id="twitter">twitter</a>
  <a id="facebook">Facebook</a>
  @if (Auth::check() && Auth::id() === $commit->user_id)
  <a href="{{ route('commits.edit', $commit->id) }}" class="single-edit-btn">
    <span>
      <span>編集する</span>
    </span>
  </a>
  @endif

@endsection
@section('scripts')
  @if(app('env') == 'local')
    <script src="{{ asset('js/share.js') }}" defer></script>
  @else
    <script src="{{ secure_asset('js/share.js') }}" defer></script>
  @endif
@endsection