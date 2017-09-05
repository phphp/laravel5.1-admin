<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('provider');
            $table->tinyInteger('rename')->default(0)
                ->comment('当oauth用户名和users表用户名重名，插入users表时临时生成新用户名，
                        rename字段设置为1表明能够修改一次用户名，修改完成改为0');

            $table->integer('open_auth_id');
            $table->string('name');
            $table->string('nickname');
            $table->string('email');
            $table->string('avatar');
            $table->string('provider_user_link');

            $table->string('access_token');
            $table->string('refresh_token')->nullable();
            $table->timestamp('expires_in');
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
        Schema::drop('oauth');
    }
}
