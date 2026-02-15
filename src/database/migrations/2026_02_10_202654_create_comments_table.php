<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            // コメントしたユーザー
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // 対象の商品
            $table->foreignId('product_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // コメント内容（最大255文字）
            $table->string('content', 255);

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
        Schema::dropIfExists('comments');
    }
}
