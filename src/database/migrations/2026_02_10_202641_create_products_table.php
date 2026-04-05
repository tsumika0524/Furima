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

        // 出品者
        $table->foreignId('user_id')
              ->constrained()
              ->cascadeOnDelete();

        // 商品情報
        $table->string('name');
        $table->string('brand')->nullable();
        $table->text('description');
        $table->unsignedInteger('price');
        $table->string('item_condition');

        // 商品画像（←必須追加）
        $table->string('image')->nullable();

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
