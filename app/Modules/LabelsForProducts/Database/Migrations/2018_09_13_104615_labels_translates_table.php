<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LabelsTranslatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labels_translates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('text');
            $table->integer('row_id')->unsigned();
            $table->string('language', 3);
    
            $table->string('h1')->nullable();
            $table->string('title')->nullable();
            $table->text('keywords')->nullable();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
    
            $table->foreign('language')->references('slug')->on('languages')
                ->index('labels_translates_language_languages_slug')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('row_id')->references('id')->on('labels')
                ->index('labels_translates_row_id_labels_id')
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
        Schema::table('labels_translates', function (Blueprint $table) {
            $table->dropForeign('labels_translates_language_languages_slug');
            $table->dropForeign('labels_translates_row_id_labels_id');
        });
        Schema::dropIfExists('labels_translates');
    }
}
