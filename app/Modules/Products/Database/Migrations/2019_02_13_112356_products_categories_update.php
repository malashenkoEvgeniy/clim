<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsCategoriesUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('products_categories')) {
            DB::table('products_categories')->delete();
        }
        Schema::table('products_categories', function (Blueprint $table) {
            $table->dropForeign('products_categories_product_id_products_id');
            $table->dropColumn('main');
            $table->dropColumn('product_id');
    
            $table->integer('group_id')->unsigned();
            
            $table->foreign('group_id')->references('id')->on('products_groups')
                ->index('products_groups_categories_group_id_products_groups_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('category_id')->references('id')->on('categories')
                ->index('products_groups_categories_category_id_categories_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            $table->rename('products_groups_categories');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('products_groups_categories')) {
            DB::table('products_groups_categories')->delete();
        }
        Schema::table('products_groups_categories', function (Blueprint $table) {
            $table->dropForeign('products_groups_categories_group_id_products_groups_id');
            $table->dropForeign('products_groups_categories_category_id_categories_id');
    
            $table->dropColumn('group_id');
    
            $table->integer('product_id')->unsigned();
            $table->boolean('main')->default(false);
    
            $table->foreign('product_id')->references('id')->on('products')
                ->index('products_categories_product_id_products_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
    
            $table->rename('products_categories');
        });
    }
}
