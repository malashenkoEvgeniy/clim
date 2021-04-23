<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrdersItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_items', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('order_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('quantity')->default(1);
            $table->double('price', 10, 2);
    
            $table->foreign('order_id')->on('orders')->references('id')
                ->index('orders_items_order_id_orders_id')
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
            Schema::table('orders_items', function (Blueprint $table) {
                $table->dropForeign('orders_items_order_id_orders_id');
            });
            Schema::dropIfExists('orders_items');
        }
    }
}
