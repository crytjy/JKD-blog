<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->string('title', 255)->comment('名称');
            $table->string('keywords', 255)->nullable(true)->comment('关键词');
            $table->string('description', 255)->nullable(true)->comment('简介');
            $table->tinyInteger('status')->default(1)->comment('状态 0：否 1：是');
            $table->tinyInteger('sort')->default(0)->comment('排序');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category');
    }
}
