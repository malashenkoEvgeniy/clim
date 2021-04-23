<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PromUa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_prom_ua', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('prom_ua_id')->index();
            
            $table->foreign('product_id')->references('id')->on('products')
                ->index('products_prom_ua_product_id_products_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products_prom_ua', function (Blueprint $table) {
            $table->dropForeign('products_prom_ua_product_id_products_id');
        });
        Schema::drop('products_prom_ua');
    }
}
