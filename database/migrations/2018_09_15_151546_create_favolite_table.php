<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoliteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorite', function (Blueprint $table) {
            $table->increments('id');
            //(unsigned)負の数を許さない,
            //(index)検索速度を速める本の最後のページの索引のような感じ
            $table->integer('user_id')->unsigned()->index();
            $table->integer('micropost_id')->unsigned()->index();
            $table->timestamps();
            
             // 外部キー設定
             //データベース側で、保存されるテーブルの整合性を
             //高めるために使われる
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('micropost_id')->references('id')->on('microposts')->onDelete('cascade');
            
             // user_idとfollow_idの組み合わせの重複を許さない
             //同じレコードがfavoriteテーブルに入るのを防ぐために書いている。
            $table->unique(['user_id', 'micropost_id']);
        });
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorite');
    }
}
