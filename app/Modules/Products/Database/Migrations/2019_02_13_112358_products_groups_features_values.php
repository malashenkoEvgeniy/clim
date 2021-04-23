<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsGroupsFeaturesValues extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_groups_features_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('feature_id')->unsigned();
            $table->integer('value_id')->unsigned();
    
            $table->foreign('group_id')->references('id')->on('products_groups')
                ->index('products_groups_features_values_group_id_products_groups_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('feature_id')->references('id')->on('features')
                ->index('products_groups_features_values_feature_id_features_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('value_id')->references('id')->on('features_values')
                ->index('products_groups_features_values_value_id_features_values_id')
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
        Schema::table('products_groups_features_values', function (Blueprint $table) {
            $table->dropForeign('products_groups_features_values_group_id_products_groups_id');
            $table->dropForeign('products_groups_features_values_feature_id_features_id');
            $table->dropForeign('products_groups_features_values_value_id_features_values_id');
            $table->dropForeign('products_groups_features_values_product_id_products_id');
        });
        Schema::dropIfExists('products_groups_features_values');
    }
    
}
