<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrdersClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_clients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
    
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            
            $table->foreign('order_id')->on('orders')->references('id')
                ->index('orders_clients_order_id_orders_id')
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
            Schema::table('orders_clients', function (Blueprint $table) {
                $table->dropForeign('orders_clients_order_id_orders_id');
            });
            Schema::dropIfExists('orders_clients');
        }
    }
}
