<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsTranslatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_translates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->integer('row_id')->unsigned();
            $table->string('language', 3);
            $table->string('h1')->nullable();
            $table->string('title')->nullable();
            $table->text('keywords')->nullable();
            $table->text('description')->nullable();
            $table->text('seo_text')->nullable();
            $table->text('text')->nullable();
        
            $table->foreign('language')->references('slug')->on('languages')
                ->index('products_translates_language_languages_slug')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('row_id')->references('id')->on('products')
                ->index('products_translates_row_id_category_id')
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
        Schema::table('products_translates', function (Blueprint $table) {
            $table->dropForeign('products_translates_language_languages_slug');
            $table->dropForeign('products_translates_row_id_category_id');
        });
        Schema::dropIfExists('products_translates');
    }
}
