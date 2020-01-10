# laravel-image-bbs
## 説明（Introduction）
### これはなに？
Laravelの学習用に作成した画像掲示板です。スレッドの作成、書き込み及び投稿時の画像添付が可能です。

**あくまで個人学習用ですので、公開Webサーバーに上げて使ったりしないでください。**

An image BBS created for Laravel learning. Thread creation, post texts and image attachment when posting are possible.

**It is for personal learning only, so please do not use it on a public web server.**
### 使い方
**実行にはXAMPPなどのPHP開発環境が必要です。また、あらかじめComposerをインストールしてLaravelが使える状態にしてください。**

**A PHP development environment such as XAMPP is required for execution. In addition, please install Composer in advance and make Laravel usable.**

1. /laravel-image-bbsを任意のフォルダに配置する。

Place /laravel-image-bbs in any folder.

2.　/laravel-image-bbs/.env.exampleを/laravel-image-bbs/.envという名前にしてコピーし、使用するデータベースに合わせて追記する。

Copy /laravel-image-bbs/.env.example as /laravel-image-bbs/.env and add it according to the database to be used.

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

    1. `composer install`
    このコマンドでLaravelが使えるようになる。
    もし
    `composer: Command not found.`
    と表示された場合、Composerがインストールされてないかパスを通ってないと思われる。
    Composerをインストールし、パスを通すかcomposer.pharをこのプログラムの中に入れてコマンドを使えるようにすること。
    This command allows you to use Laravel.
    If you don't see the following, it's likely that Composer isn't installed or isn't in your path.
    `composer: Command not found.`
    Install Composer and move composer.phar to the path location or into this program directory so that you can use Composer commands.
    
    2. `php artisan migrate`
    このコマンドでデータベースにテーブルが作成される。
    This command creates a table in the database.
    
    3. `php artisan serve`
    このコマンドで開発サーバーが起動する。
    This command starts the development server.
    
    4. `php artisan storage:link`
    このコマンドでストレージへのシンボリックリンクが貼られ、アップロードした画像ファイルにアクセスできる。
    This command attaches a symbolic link to the storage and allows you to access the uploaded image file.    

5. `http://localost:8000/index` にアクセスすることで、掲示板を使用することができるはずである。

You should be able to use the BBS by accessing `http://localost:8000/index`.

問題があればIssuesに投稿してください。

Please post any issues to Issues.
