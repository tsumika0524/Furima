<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // 出品者（usersテーブルと紐づく）
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // 商品情報
            $table->string('name');              // 商品名
            $table->string('brand')->nullable(); // ブランド名
            $table->text('description');         // 商品説明
            $table->integer('price');            // 販売価格
            $table->string('condition');          // 商品の状態

            // 購入済み判定
            $table->boolean('is_sold')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
