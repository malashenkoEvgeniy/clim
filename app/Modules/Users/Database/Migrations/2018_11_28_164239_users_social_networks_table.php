<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersSocialNetworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_networks', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->on('users')->references('id')
                ->index('users_networks_user_id_users_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('network');
            $table->string('uid');
            $table->string('link')->nullable();
            $table->string('email');
            $table->text('data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (app()->environment() !== 'production') {
            Schema::table('users_networks', function (Blueprint $table) {
                $table->dropForeign('users_networks_user_id_users_id');
            });
            Schema::dropIfExists('users_networks');
        }
    }
}
