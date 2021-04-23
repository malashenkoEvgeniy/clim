<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsGroupsLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_groups_labels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->unsigned();
            $table->integer('label_id')->unsigned();
    
            $table->foreign('label_id')->references('id')->on('labels')
                ->index('products_groups_labels_label_id_labels_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('group_id')->references('id')->on('products_groups')
                ->index('products_groups_labels_group_id_products_groups_id')
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
        Schema::table('products_groups_labels', function (Blueprint $table) {
            $table->dropForeign('products_groups_labels_label_id_labels_id');
            $table->dropForeign('products_groups_labels_group_id_products_groups_id');
        });
        Schema::drop('products_groups_labels');
    }
}
