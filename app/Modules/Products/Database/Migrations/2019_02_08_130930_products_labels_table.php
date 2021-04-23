<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_labels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('label_id')->unsigned();
            $table->integer('product_id')->unsigned();

            $table->foreign('product_id')->references('id')->on('products')
                ->index('products_labels_product_id_products_id')
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
        Schema::table('products_labels', function (Blueprint $table) {
            $table->dropForeign('products_labels_product_id_products_id');
        });
        Schema::dropIfExists('products_labels');
    }
}
