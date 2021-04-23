<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            
            $table->boolean('do_not_call_me')->default(false);
            $table->boolean('paid')->default(false);
            
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->string('comment')->nullable();
            
            $table->string('delivery')->nullable();
            $table->string('delivery_address')->nullable();
            
            $table->string('payment_method')->nullable();
    
            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->on('orders_statuses')->references('id')
                ->index('orders_status_id_orders_statuses_id')
                ->onUpdate('cascade')
                ->onDelete('set null');
    
            $table->integer('user_id')->unsigned()->nullable();
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
            Schema::table('orders', function (Blueprint $table) {
                $table->dropForeign('orders_status_id_orders_statuses_id');
            });
            Schema::dropIfExists('orders');
        }
    }
}
