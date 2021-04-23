<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsServicesTranslatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_services_translates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('row_id')->unsigned();
            $table->string('language', 3);
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('text')->nullable();
        
            $table->foreign('language')->references('slug')->on('languages')
                ->index('products_services_translates_language_languages_slug')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('row_id')->references('id')->on('products_services')
                ->index('products_services_translates_row_id_products_services_id')
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
        Schema::table('products_services_translates', function (Blueprint $table) {
            $table->dropForeign('products_services_translates_language_languages_slug');
            $table->dropForeign('products_services_translates_row_id_products_services_id');
        });
        Schema::dropIfExists('products_services_translates');
    }
}
