<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatearticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->unsignedBigInteger('category_id')->comment('分类ID');
            $table->unsignedBigInteger('user_id')->comment('用户ID');
            $table->string('author', 255)->comment('作者');
            $table->string('title', 255)->comment('名称');
            $table->longText('content')->comment('文章内容');
            $table->string('keywords', 255)->comment('关键词');
            $table->string('description', 255)->comment('描述');
            $table->tinyInteger('is_top')->default(0)->comment('置顶 0：否 1：是');
            $table->tinyInteger('is_original')->default(0)->comment('是否原创 0：否 1：是');
            $table->integer('click')->default(0)->comment('点击数');
            $table->string('mp3_url', 255)->nullable(true)->comment('mp3 链接');
            $table->string('pic', 255)->nullable(true)->comment('封面图片');
            $table->tinyInteger('status')->default(1)->comment('状态 0：否 1：是');
            $table->unsignedBigInteger('last_update_id')->comment('最后修改人员ID');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('category_id')->references('id')->on('category');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('last_update_id')->references('id')->on('users');
        });


        Schema::create('article_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('article_id')->comment('文章ID');
            $table->unsignedBigInteger('tag_id')->comment('标签ID');
            $table->foreign('article_id')->references('id')->on('article');
            $table->foreign('tag_id')->references('id')->on('tag');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article');
        Schema::dropIfExists('article_tag');
    }
}
