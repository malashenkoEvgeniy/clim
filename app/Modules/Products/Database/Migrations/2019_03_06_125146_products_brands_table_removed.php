<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsBrandsTableRemoved extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('products_brands')) {
            Schema::table('products_brands', function (Blueprint $table) {
                $table->dropForeign('products_brands_product_id_products_id');
            });
            Schema::dropIfExists('products_brands');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('products_brands') === false) {
            Schema::create('products_brands', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('brand_id')->unsigned();
                $table->integer('product_id')->unsigned();
            
                $table->foreign('product_id')->references('id')->on('products')
                    ->index('products_brands_product_id_products_id')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });
        }
    }
}
