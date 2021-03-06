@extends('layouts.app')
@section('title')
  <title>マイページ | Commit</title>
@endsection
@section('content')
  <main id="mypage">
    <div class="wrap ptb40-80">
      <div class="user-info-wrap">
        @if (session('message'))
          <div class="message alert alert-success">
            {{ session('message') }}
          </div>
        @endif
        <form method="POST" action="{{ route('home.update', Auth::user()->id) }}">
          @csrf
          <input type="hidden" name="_method" value="PUT">
          <div class="info">
            <div class="user-name form-item">
              <span>ユーザー名</span>
              <div class="">
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}" maxlength='25' required>
                @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong class="error">{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="email form-item">
              <span>メールアドレス</span>
              <div class="">
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="メールアドレスは、aaa@example.com のような形式で記入してください。" required>

                @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong class="error">{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="pass form-item">
              <span>パスワード</span>
              <div class="">
                <input type="password" name="password" value="" placeholder="変更しない場合は空欄">

                @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong class="error">{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
          </div>

          <input type="submit" name="" value="変更する">
        </form>
      </div>

      <div class="commit-list-wrap">
        <div class="commit-list">
          <h2>現在のCommit</h2>
          <ul class="current-ul">
            @foreach($currentCommits as $commit)
            <li id="commit-item-bloc-{{ $commit->id }}" class="block">
              <a href="{{ route('commits.show', $commit->id) }}" >
                <div class="">
                  <h3>{{date('Y/m/d', strtotime($commit->limit))}}までの{{count($commit->commitGroups)}}コミット</h3>
                  <ol>
                    @foreach($commit->commitGroups as $key => $commitGroup)
                      @if ($key < 2)
                        <li>{{$commitGroup->content}}</li>
                      @endif
                    @endforeach
                  </ol>
                </div>
                <span class="arrow"></span>
              </a>
            </li>
            @endforeach
            @if (100 < $currentCommitsCount)
              <li class="button">
                <button id="currentMoreButton" class="button" onclick="loadMore('current')">もっと見る</button>
              </li>
            @endif
          </ul>
        </div>
        <div class="commit-list">
          <h2>過去のCommit</h2>
          <ul class="previous-ul">
            @foreach($previousCommits as $commit)
            <li id="commit-item-bloc-{{ $commit->id }}" class="block">
              <a href="{{ route('commits.show', $commit->id) }}" >
                <div class="">
                  <h3>{{date('Y/m/d', strtotime($commit->limit))}}までの{{count($commit->commitGroups)}}コミット</h3>
                  <ol>
                    @foreach($commit->commitGroups as $key => $commitGroup)
                      @if ($key < 2)
                        <li>{{$commitGroup->content}}</li>
                      @endif
                    @endforeach
                  </ol>
                </div>
                <span class="arrow"></span>
              </a>
            </li>
            @endforeach
            @if (100 < $previousCommitsCount)
              <li class="button">
                <button id="previousMoreButton" class="button" onclick="loadMore('previous')">もっと見る</button>
              </li>
            @endif
          </ul>
        </div>
      </div>
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
  @if(app('env') == 'local')
    <script src="{{ asset('js/home.js') }}" defer></script>
  @else
    <script src="{{ secure_asset('js/home.js') }}" defer></script>
  @endif
@endsection
