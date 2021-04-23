<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts_items', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('quantity')->default(1);
            $table->integer('cart_id')->unsigned();
    
            $table->foreign('cart_id')->on('carts')->references('id')
                ->index('carts_items_cart_id_carts_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
    
            $table->integer('product_id')->unsigned();
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
            Schema::table('carts_items', function (Blueprint $table) {
                $table->dropForeign('carts_items_cart_id_carts_id');
            });
            Schema::dropIfExists('carts_items');
        }
    }
}
