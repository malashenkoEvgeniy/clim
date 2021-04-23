<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImagesTableTranslates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images_translates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('alt')->nullable();
            $table->string('title')->nullable();
            $table->integer('row_id')->unsigned();
            $table->string('language', 3);
    
            $table->foreign('language')->references('slug')->on('languages')
                ->index('images_translates_language_languages_slug')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('row_id')->references('id')->on('images')
                ->index('images_translates_row_id_images_id')
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
            Schema::table('images_translates', function (Blueprint $table) {
                $table->dropForeign('images_translates_language_languages_slug');
                $table->dropForeign('images_translates_row_id_images_id');
            });
            Schema::drop('images_translates');
        }
    }
}
