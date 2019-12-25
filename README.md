# laravel-image-bbs
## 説明（Introduction）
### これはなに？
Laravelの学習用に作成した画像掲示板です。スレッドの作成、書き込み及び投稿時の画像添付が可能です。

**あくまで個人学習用ですので、公開Webサーバーに上げて使ったりしないでください。**

An image BBS created for Laravel learning. Thread creation, post texts and image attachment when posting are possible.

**It is for personal learning only, so please do not use it on a public web server.**
### 使い方
**実行にはXAMPPなどのPHP開発環境が必要です。**

**A PHP development environment such as XAMPP is required for execution.**

1. /laravel-image-bbsを任意のフォルダに配置する。

Place /laravel-image-bbs in any folder.

2. /laravel-image-bbs/config/database.php及び/laravel-image-bbs/.envを使用するデータベースに合わせて追記する。

Add /laravel-image-bbs/config/database.php and /laravel-image-bbs/.env according to the database to be used.

例(example /laravel-image-bbs/config/database.php)

```
    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'xxxxxx'),
            'username' => env('DB_USERNAME', 'xxxxxxxxx'),
            'password' => env('DB_PASSWORD', 'xxxxxxxxxxx'),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
        // replace "xxxxxx" according to your database setting.
```

例(example /laravel-image-bbs/.env)

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=XXXXXXXX
DB_USERNAME=XXXXXXXXXXXX
DB_PASSWORD=XXXXXXXXXXXXX

// rewrite DB_CONNECTION, DB_DATABASE, DB_USERNAME and DB_PASSWORD according to your database setting.
```
3. コマンドラインでlaravel-image-bbsの場所に移動し、以下のコマンドを実行せよ。

Go to the location of laravel-image-bbs on the command line and execute the following command.

    1. `php artisan migrate`
    このコマンドでデータベースにテーブルが作成される。
    This command creates a table in the database.
    2. `php artisan serve`
    このコマンドで開発サーバーが起動する。
    This command starts the development server.
4. `http://localost:8000/index` にアクセスすることで、掲示板を使用することができるはずである。

You should be able to use the BBS by accessing `http://localost:8000/index`.

問題があればIssuesに投稿してください。

Please post any issues to Issues.
