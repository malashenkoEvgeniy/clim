<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFastOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fast_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone');
            $table->string('name')->nullable();
            $table->string('ip');
            $table->integer('product_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')
                ->index('fast_orders_product_id_products_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('user_id')->on('users')->references('id')
                ->index('fast_orders_user_id_users_id')
                ->onUpdate('cascade')
                ->onDelete('set null');
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
            Schema::table('fast_orders', function (Blueprint $table) {
                $table->dropForeign('fast_orders_product_id_products_id');
                $table->dropForeign('fast_orders_user_id_users_id');
            });
            Schema::dropIfExists('fast_orders');
        }
    }
}
