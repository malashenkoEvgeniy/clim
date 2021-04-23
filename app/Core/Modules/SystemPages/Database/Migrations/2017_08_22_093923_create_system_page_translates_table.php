<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemPageTranslatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'system_pages_translates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->text('content')->nullable();
            $table->string('h1')->nullable();
            $table->string('title')->nullable();
            $table->text('keywords')->nullable();
            $table->text('description')->nullable();
            $table->string('language', 3);
            $table->integer('row_id')->unsigned();
            
            $table->foreign('language')->references('slug')->on('languages')
                ->index('system_pages_translates_language_languages_slug')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            $table->foreign('row_id')->references('id')->on('system_pages')
                ->index('system_pages_translates_row_id_system_pages_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        }
        );
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (app()->environment() !== 'production') {
            Schema::table(
                'system_pages_translates', function (Blueprint $table) {
                $table->dropForeign('system_pages_translates_language_languages_slug');
                $table->dropForeign('system_pages_translates_row_id_system_pages_id');
            }
            );
            Schema::dropIfExists('system_pages_translates');
        }
    }
}
