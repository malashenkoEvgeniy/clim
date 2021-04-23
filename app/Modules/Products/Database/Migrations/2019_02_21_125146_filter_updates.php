<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FilterUpdates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products_filters', function (Blueprint $table) {
            $table->dropForeign('products_filters_product_id_products_id');
            $table->dropForeign('products_filters_language_languages_slug');
        });
        Schema::dropIfExists('products_filters');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('products_filters', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('language', 3);
            $table->integer('product_id')->unsigned();
            $table->string('parameter')->index();
            $table->string('value')->index();
        
            $table->foreign('product_id')->on('products')->references('id')
                ->index('products_filters_product_id_products_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('language')->references('slug')->on('languages')
                ->index('products_filters_language_languages_slug')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
