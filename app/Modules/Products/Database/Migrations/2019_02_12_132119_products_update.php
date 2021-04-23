<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_main')->default(false);
            $table->integer('value_id')->unsigned()->nullable();
            $table->integer('group_id')->unsigned()->nullable();
            $table->integer('brand_id')->unsigned()->nullable();
            $table->foreign('group_id')->on('products_groups')->references('id')
                ->index('products_group_id_products_groups_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('value_id')->on('features_values')->references('id')
                ->index('products_value_id_features_values_id')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->foreign('brand_id')->on('brands')->references('id')
                ->index('products_brand_id_brands_id')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_group_id_products_groups_id');
            $table->dropForeign('products_value_id_features_values_id');
            $table->dropForeign('products_brand_id_brands_id');
            $table->dropColumn('group_id');
            $table->dropColumn('value_id');
            $table->dropColumn('brand_id');
            $table->dropColumn('is_main');
        });
    }
}
