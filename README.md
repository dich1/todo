# Todo
## Setup
```
git clone https://github.com/dich1/todo.git 
cd todo
git clone https://github.com/laradock/laradock.git
cd laradock 
cp env-example .env
sed -ie 's/APP_CODE_PATH_HOST=..\//APP_CODE_PATH_HOST=..\/todo/g' .env
sed -ie 's/MYSQL_VERSION=latest/MYSQL_VERSION=5.7/g' .env
rm .enve
docker-compose up -d workspace nginx mysql
docker-compose exec workspace bash
```
### Access
http://127.0.0.1

## Heroku
```
heroku auth:login
heroku create todo-54321 --buildpack heroku/php
echo 'web: vendor/bin/heroku-php-apache2 public/' > src/Procfile
sed Schema::defaultStringLength(191); app\Providers\AppServiceProvider.php

git add .
git commit -m '[chore]for heroku setup file' 

cd ~/workspace/todo/laradock
docker-compose exec workspace php artisan --no-ansi key:generate --show
cd ~/workspace/todo
heroku config:set APP_KEY=
git subtree push --prefix src/ heroku master
heroku addons:add cleardb
heroku config | grep CLEARDB_DATABASE_URL
heroku config:set DB_DATABASE=
heroku config:set DB_HOST=
heroku config:set DB_USERNAME=
heroku config:set DB_PASSWORD=
heroku config:set APP_ENV=heroku
heroku config:set LANG=ja_JP.UTF-8
heroku config:set TZ=Asia/Tokyo
heroku run php artisan migrate
heroku open
```

## Detail
- see
  - https://qiita.com/dich1/items/552b1de430d806fe49ac
