<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
    $table->id();

    // 購入者
    $table->foreignId('user_id')
          ->constrained()
          ->cascadeOnDelete();

    // 購入商品
    $table->foreignId('product_id')
          ->constrained()
          ->cascadeOnDelete();

    // 支払い方法
    $table->string('payment_method');

    // 購入金額
    $table->unsignedInteger('total_price');

    // 配送先住所
    $table->string('postal_code',8);
    $table->string('address');
    $table->string('building')->nullable();

    $table->timestamps();

    // 1商品1購入制約（超重要）
    $table->unique('product_id');
});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
