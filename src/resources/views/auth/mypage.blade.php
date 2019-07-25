@extends('layouts.app')

@section('content')
  <main id="mypage">
    <div class="wrap ptb40-80">
      <div class="user-info-wrap">
        <form class="" action="index.html" method="post">
          <div class="info">
            <div class="user-name form-item">
              <span>ユーザー名</span>
              <div class="">
                <input type="text" name="" value="{{ Auth::user()->name }}">
              </div>
            </div>

            <div class="email form-item">
              <span>メールアドレス</span>
              <div class="">
                <input type="email" name="" value="">
              </div>
            </div>

            <div class="pass form-item">
              <span>パスワード</span>
              <div class="">
                <input type="password" name="" value="" placeholder="変更しない場合は空欄">
              </div>
            </div>
          </div>

          <input type="submit" name="" value="更 新">
        </form>
      </div>

      <div class="commit-list-wrap">
        <div class="commit-list">
          <h2>現在のCommit</h2>
          <ul>
            @foreach($commits as $commit)
            @if (!$commit->status)
            <li>
              <a href="{{ route('commits.show', $commit->id) }}" target="_blank">
                <div class="">
                  <h3>{{$commit->limit}}までの{{count($commit->commitGroups)}}コミット</h3>
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
            @endif
            @endforeach
          </ul>
        </div>
        <div class="commit-list">
          <h2>過去のCommit</h2>
          <ul>
            @foreach($commits as $commit)
            @if ($commit->status)
            <li>
              <a href="{{ route('commits.show', $commit->id) }}" target="_blank">
                <div class="">
                  <h3>2019.12.1までの20コミット</h3>
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
            @endif
            @endforeach
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