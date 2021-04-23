<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsRelatedTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_related', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('related_id')->unsigned();

            $table->foreign('product_id')->references('id')->on('products')
                    ->index('products_related_product_id_products_id')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreign('related_id')->references('id')->on('products')
                    ->index('products_related_related_id_products_id')
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
            Schema::table('products_related', function (Blueprint $table) {
                $table->dropForeign('products_related_product_id_products_id');
                $table->dropForeign('products_related_related_id_products_id');
            });
            Schema::dropIfExists('products_related');
        }
    }

}
