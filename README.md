# アプリケーション
フリマアプリ（商品売買サービス）

本アプリケーションは、ユーザーが商品を出品・購入できるフリマサービスです。<br>
会員登録・ログイン機能を備え、商品検索、いいね、コメント、購入機能などを実装しています。<br>

## 環境構築

### 1. Docker ビルド
・git clone git@github.com:tsumika0524/Furima.git<br>
・docker-compose build

### Laravel環境構築
docker-compose up -d<br>
docker exec -it Furima bash<br>
cp .env.example .env<br>
php artisan key:generate<br>
composer install<br>
npm install<br>
npm run dev<br>
php artisan migrate<br>
php artisan db:seed<br>

#### 環境開発URL
・商品一覧：http://localhost<br>
・マイリスト：http://localhost/?tab=mylist<br>
・ログイン:http://localhost/login<br>
・商品詳細: http://localhost/item/{item_id}<br>
・商品購入：http://localhost/purchase/{item_id}<br>
・住所変更：http://localhost/purchase/address/{item_id}<br>
・商品出品：http://localhost/sell<br>
・プロフィール：http://localhost/purchase/mypage<br>
・プロフィール編集：http://localhost/mypage/profile<br>
・購入商品一覧：http://localhost/mypage?page=buy<br>
・出品商品一覧：http://localhost/mypage?page=sell<br>


##### 使用技術(実行環境)
・PHP 8.4.13<br>
・Laravel 8.83.29<br>
・MySQL 8.0.26 <br>
・nginx 1.21.1 <br>
・jquery 3.7.1.min.js<br>

######　ER図
![ER図](src/docs/ER図.png)