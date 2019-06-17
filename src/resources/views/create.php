<!doctype html>
<html lang="ja"><head>
  <meta charset="utf8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>新規作成 | Commit</title>
  <meta name="descpription" content="〇〇を使って、【2019年12月1日までにやりたい20個のこと】に挑戦中！">
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="css/style.css" media="all">
</head>
<body>
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



  <div class="breadcrumb wrap">
    <ul>
      <li><a href="#">マイページ</a></li>
      <li>新規作成</li>
    </ul>
  </div>



  <main id="commit-create">
    <div class="wrap600 ptb40-80">
      <form class="" action="index.html" method="post">
        <div class="">
          <div class="commit-item-wrap">
            <span class="commit-item">期限</span>
            <div class="form-select">
              <div class="select-wrap year">
                <select class="" name="">
                  <option value="2019">2019年</option>
                  <option value="2020">2020年</option>
                  <option value="2021">2021年</option>
                  <option value="2022">2022年</option>
                </select>
              </div>

              <div class="select-wrap  month">
                <select class="" name="">
                  <option value="1">1月</option>
                  <option value="2">2月</option>
                  <option value="3">3月</option>
                  <option value="4">4月</option>
                </select>
              </div>

              <div class="select-wrap day">
                <select class="" name="">
                  <option value="1">1日</option>
                  <option value="2">2日</option>
                  <option value="3">3日</option>
                  <option value="4">4日</option>
                </select>
              </div>
            </div>
          </div>

          <div class="commit-item-wrap">
            <span class="commit-item">Commit内容</span>
            <p class="attention">※1行に1つ記入してください。</p>
            <div class="">
              <textarea name="name" rows="8" cols="80"></textarea>
            </div>
          </div>
        </div>

        <input type="submit" name="" value="この内容で決定">
      </form>
    </div>
  </main>



  <footer id="footer" class="wrap">
    <small>© Copyright 2019 xxx All rights reserved.</small>
  </footer>

  <script src="js/jquery.js"></script>
  <script src="js/main.js"></script>


</body></html>