<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsFeatureValuesTableRemoved extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products_features_values', function (Blueprint $table) {
            $table->dropForeign('products_features_values_product_id_products_id');
        });
        Schema::dropIfExists('products_features_values');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('products_features_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('feature_id')->unsigned();
            $table->integer('value_id')->unsigned();
        
            $table->foreign('product_id')->references('id')->on('products')
                ->index('products_features_values_product_id_products_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

}
