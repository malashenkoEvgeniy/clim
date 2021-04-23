<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsRelatedUpdate extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('products_related')) {
            DB::table('products_related')->delete();
        }
        Schema::table('products_related', function (Blueprint $table) {
            $table->dropForeign('products_related_product_id_products_id');
            $table->dropForeign('products_related_related_id_products_id');
    
            $table->dropColumn('product_id');
    
            $table->integer('group_id')->unsigned();

            $table->foreign('group_id')->references('id')->on('products_groups')
                    ->index('products_related_group_id_products_groups_id')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreign('related_id')->references('id')->on('products_groups')
                    ->index('products_related_related_id_products_groups_id')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            
            $table->rename('products_groups_related');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('products_groups_related')) {
            DB::table('products_groups_related')->delete();
        }
        Schema::table('products_groups_related', function (Blueprint $table) {
            $table->dropForeign('products_related_group_id_products_groups_id');
            $table->dropForeign('products_related_related_id_products_groups_id');
        
            $table->dropColumn('group_id');
    
            $table->integer('product_id')->unsigned();
    
            $table->foreign('product_id')->references('id')->on('products')
                ->index('products_related_product_id_products_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('related_id')->references('id')->on('products')
                ->index('products_related_related_id_products_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        
            $table->rename('products_related');
        });
    }

}
