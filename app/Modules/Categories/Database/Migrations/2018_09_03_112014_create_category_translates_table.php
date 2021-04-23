<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTranslatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_translates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->integer('row_id')->unsigned();
            $table->string('language', 3);
            $table->string('h1')->nullable();
            $table->string('title')->nullable();
            $table->string('keywords')->nullable();
            $table->text('description')->nullable();
            $table->text('seo_text')->nullable();

            $table->foreign('language')->references('slug')->on('languages')
                ->index('category_translates_language_languages_slug')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('row_id')->references('id')->on('categories')
                ->index('category_translates_row_id_category_id')
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
        if (app()->environment() !== 'production') {
            Schema::table('categories_translates', function (Blueprint $table) {
                $table->dropForeign('category_translates_language_languages_slug');
                $table->dropForeign('category_translates_row_id_category_id');
            });
            Schema::dropIfExists('categories_translates');
        }
    }
}
