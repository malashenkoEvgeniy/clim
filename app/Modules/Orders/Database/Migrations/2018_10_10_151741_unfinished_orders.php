<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UnfinishedOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts_unfinished_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            
            $table->text('information')->nullable();
    
            $table->integer('cart_id')->unsigned()->nullable();
    
            $table->foreign('cart_id')->on('carts')->references('id')
                ->index('carts_unfinished_orders_cart_id_carts_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
            Schema::table('carts_unfinished_orders', function (Blueprint $table) {
                $table->dropIndex('carts_unfinished_orders_cart_id_carts_id');
            });
            Schema::dropIfExists('carts_unfinished_orders');
        }
    }
}
