<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FeaturesValuesTranslatesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('features_values_translates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->integer('row_id')->unsigned();
            $table->string('language', 3);
            $table->timestamps();
            
            $table->foreign('language')->references('slug')->on('languages')
                    ->index('features_values_translates_language_languages_slug')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreign('row_id')->references('id')->on('features_values')
                    ->index('features_values_row_id_features_values_id')
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
        Schema::table('features_values_translates', function (Blueprint $table) {
            $table->dropForeign('features_values_translates_language_languages_slug');
            $table->dropForeign('features_values_row_id_features_values_id');
        });
        Schema::dropIfExists('features_values_translates');
    }

}
