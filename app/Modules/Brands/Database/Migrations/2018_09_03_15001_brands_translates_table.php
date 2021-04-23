<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BrandsTranslatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands_translates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->text('content')->nullable();
            $table->string('h1')->nullable();
            $table->string('title')->nullable();
            $table->text('keywords')->nullable();
            $table->text('description')->nullable();
            $table->integer('row_id')->unsigned();
            $table->string('language', 3);
        
            $table->foreign('language')->references('slug')->on('languages')
                ->index('brands_translates_language_languages_slug')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('row_id')->references('id')->on('brands')
                ->index('brands_translates_row_id_brands_id')
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
            Schema::table('brands_translates', function (Blueprint $table) {
                $table->dropForeign('brands_translates_language_languages_slug');
                $table->dropForeign('brands_translates_row_id_brands_id');
            });
            Schema::dropIfExists('brands_translates');
        }
    }
}
