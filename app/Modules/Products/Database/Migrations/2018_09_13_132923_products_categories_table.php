<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->boolean('main')->default(false);
    
            $table->foreign('product_id')->references('id')->on('products')
                ->index('products_categories_product_id_products_id')
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
        if (app()->environment() !== 'productions') {
            Schema::table('products_categories', function (Blueprint $table) {
                $table->dropForeign('products_categories_product_id_products_id');
            });
            Schema::dropIfExists('products_categories');
        }
    }
}
