<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeoLinksTranslatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_links_translates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('h1')->nullable();
            $table->string('title')->nullable();
            $table->text('keywords')->nullable();
            $table->text('description')->nullable();
            $table->integer('row_id')->unsigned();
            $table->string('language', 3);

            $table->foreign('language')->references('slug')->on('languages')
                ->index('seo_links_translates_language_languages_slug')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('row_id')->references('id')->on('seo_links')
                ->index('seo_links_translates_row_id_seo_links_id')
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
            Schema::table('seo_links_translates', function (Blueprint $table) {
                $table->dropForeign('seo_links_translates_language_languages_slug');
                $table->dropForeign('seo_links_translates_row_id_seo_links_id');
            });
            Schema::dropIfExists('seo_links_translates');
        }
    }
}
