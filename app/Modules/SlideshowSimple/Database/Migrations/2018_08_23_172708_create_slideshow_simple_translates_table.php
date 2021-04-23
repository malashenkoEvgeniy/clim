<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlideshowSimpleTranslatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slideshow_simple_translates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('row_1')->nullable();
            $table->string('row_2')->nullable();
            $table->string('row_3')->nullable();
            $table->integer('row_id')->unsigned();
            $table->string('language', 3);

            $table->foreign('language')->references('slug')->on('languages')
                ->index('slideshow_simple_translates_language_languages_slug')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('row_id')->references('id')->on('slideshow_simple')
                ->index('slideshow_simple_translates_row_id_slideshow_simple_id')
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
            Schema::table('slideshow_simple_translates', function (Blueprint $table) {
                $table->dropForeign('slideshow_simple_translates_language_languages_slug');
                $table->dropForeign('slideshow_simple_translates_row_id_slideshow_simple_id');
            });
            Schema::dropIfExists('slideshow_simple_translates');
        }
    }
}
