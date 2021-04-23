<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsLabelsUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products_labels', function (Blueprint $table) {
            $table->foreign('label_id')->references('id')->on('labels')
                ->index('products_labels_label_id_labels_id')
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
            $table->dropForeign('products_labels_label_id_labels_id');
        });
    }
}
