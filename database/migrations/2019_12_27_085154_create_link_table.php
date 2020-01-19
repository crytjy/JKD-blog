<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->string('title', 255)->comment('名称');
            $table->string('url', 255)->comment('链接');
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
        Schema::dropIfExists('link');
    }
}
