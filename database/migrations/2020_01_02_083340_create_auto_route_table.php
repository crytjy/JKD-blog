<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoRouteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_route', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->string('name', 255)->comment('模型名称');
            $table->string('controller_name', 255)->comment('控制器名称');
            $table->timestamps();
            $table->unique('name');
            $table->unique('controller_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_route');
    }
}
