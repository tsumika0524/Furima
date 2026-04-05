<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // ユーザー作成（なければ）
        $user = User::first() ?? User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // カテゴリ一覧
        $categoryNames = [
            'ファッション',
            '家電',
            'インテリア',
            'レディース',
            'メンズ',
            'コスメ',
            '本',
            'ゲーム',
            'スポーツ',
            'キッチン',
            'ハンドメイド',
            'アクセサリー',
            'おもちゃ',
            'ベビー・キッズ',
        ];

        $categories = [];

        foreach ($categoryNames as $name) {
            $cat = Category::firstOrCreate(['name' => $name]);
            $categories[$name] = $cat->id;
        }

        // 商品データ（カテゴリ固定）
        $products = [

            [
                'name'=>'腕時計',
                'price'=>15000,
                'brand'=>'Rolax',
                'description'=>'スタイリッシュなデザインのメンズ腕時計',
                'image'=>'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
                'item_condition'=>'良好',
                'category'=>['ファッション','メンズ']
            ],
            [
                'name'=>'HDD',
                'price'=>5000,
                'brand'=>'西芝',
                'description'=>'高速で信頼性の高いハードディスク',
                'image'=>'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
                'item_condition'=>'目立った傷や汚れなし',
                'category'=>['家電']
            ],
            [
                'name'=>'玉ねぎ3束',
                'price'=>300,
                'brand'=>null,
                'description'=>'新鮮な玉ねぎ3束のセット',
                'image'=>'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
                'item_condition'=>'やや傷や汚れあり',
                'category'=>['キッチン']
            ],
            [
                'name'=>'革靴',
                'price'=>4000,
                'brand'=>null,
                'description'=>'クラシックなデザインの革靴',
                'image'=>'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
                'item_condition'=>'状態が悪い',
                'category'=>['ファッション','メンズ']
            ],
            [
                'name'=>'ノートPC',
                'price'=>45000,
                'brand'=>null,
                'description'=>'高性能なノートパソコン',
                'image'=>'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
                'item_condition'=>'良好',
                'category'=>['家電']
            ],
            [
                'name'=>'マイク',
                'price'=>8000,
                'brand'=>null,
                'description'=>'高音質のレコーディング用マイク',
                'image'=>'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
                'item_condition'=>'目立った傷や汚れなし',
                'category'=>['家電']
            ],
            [
                'name'=>'ショルダーバッグ',
                'price'=>3500,
                'brand'=>null,
                'description'=>'おしゃれなショルダーバッグ',
                'image'=>'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
                'item_condition'=>'やや傷や汚れあり',
                'category'=>['ファッション','レディース']
            ],
            [
                'name'=>'タンブラー',
                'price'=>500,
                'brand'=>null,
                'description'=>'使いやすいタンブラー',
                'image'=>'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
                'item_condition'=>'状態が悪い',
                'category'=>['キッチン']
            ],
            [
                'name'=>'コーヒーミル',
                'price'=>4000,
                'brand'=>'Starbacks',
                'description'=>'手動のコーヒーミル',
                'image'=>'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
                'item_condition'=>'良好',
                'category'=>['キッチン']
            ],
            [
                'name'=>'メイクセット',
                'price'=>2500,
                'brand'=>null,
                'description'=>'便利なメイクアップセット',
                'image'=>'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
                'item_condition'=>'目立った傷や汚れなし',
                'category'=>['コスメ','レディース']
            ],
        ];

        foreach($products as $p){

            $categoryNames = $p['category'];
            unset($p['category']);

            $p['user_id'] = $user->id;

            $product = Product::create($p);

            $attachIds = [];

            foreach ($categoryNames as $catName) {
                if (isset($categories[$catName])) {
                    $attachIds[] = $categories[$catName];
                }
            }

            $product->categories()->attach($attachIds);
        }
    }
}