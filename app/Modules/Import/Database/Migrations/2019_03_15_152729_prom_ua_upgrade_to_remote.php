<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PromUaUpgradeToRemote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products_prom_ua', function (Blueprint $table) {
            $table->dropForeign('products_prom_ua_product_id_products_id');
            $table->renameColumn('prom_ua_id', 'remote_id');
            $table->renameColumn('product_id', 'group_id');
            $table->string('system')->nullable();
            $table->foreign('group_id')->references('id')->on('products_groups')
                ->index('products_groups_remote_group_id_products_groups_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->rename('products_groups_remote');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products_groups_remote', function (Blueprint $table) {
            $table->dropForeign('products_groups_remote_group_id_products_groups_id');
            $table->renameColumn('remote_id', 'prom_ua_id');
            $table->renameColumn('group_id', 'product_id');
            $table->dropColumn('system');
            $table->foreign('product_id')->references('id')->on('products')
                ->index('products_prom_ua_product_id_products_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->rename('products_prom_ua');
        });
    }
}
