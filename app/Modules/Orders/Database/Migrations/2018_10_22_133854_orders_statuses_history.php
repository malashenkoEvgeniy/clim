<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrdersStatusesHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_statuses_history', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            
            $table->string('color')->default('#000000');
            $table->string('comment')->nullable();
            $table->integer('order_id')->unsigned();
    
            $table->foreign('order_id')->on('orders')->references('id')
                ->index('osh_items_order_id_orders_id')
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
            Schema::table('orders_statuses_history', function (Blueprint $table) {
                $table->dropForeign('osh_items_order_id_orders_id');
            });
            Schema::dropIfExists('orders_statuses_history');
        }
    }
}
