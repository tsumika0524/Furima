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

            // 支払い方法（コンビニ / カード）
            $table->string('payment_method');

            // 購入金額
            $table->integer('total_price');

            // 配送先住所（購入時点の情報を保持）
            $table->string('postal_code');
            $table->string('address');
            $table->string('building')->nullable();

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
        Schema::dropIfExists('purchases');
    }
}
