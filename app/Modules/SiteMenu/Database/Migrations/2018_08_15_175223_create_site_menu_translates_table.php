<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteMenuTranslatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_menu_translates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('slug_type');
            $table->string('language', 3);
            $table->integer('row_id')->unsigned();
            
            $table->foreign('language')->references('slug')->on('languages')
                ->index('site_menu_translates_language_languages_slug')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            $table->foreign('row_id')->references('id')->on('site_menu')
                ->index('site_menu_translates_row_id_site_menu_id')
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
            Schema::table('site_menu_translates', function (Blueprint $table) {
                $table->dropForeign('site_menu_translates_language_languages_slug');
                $table->dropForeign('site_menu_translates_row_id_site_menu_id');
            });
            Schema::dropIfExists('site_menu_translates');
        }
    }
}
