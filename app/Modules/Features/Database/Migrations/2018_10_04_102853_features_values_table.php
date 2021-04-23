<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FeaturesValuesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('features_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('position')->default(0);
            $table->boolean('active')->default(false);
            $table->integer('feature_id')->unsigned()->nullable();
            $table->timestamps();
            
            $table->foreign('feature_id')->references('id')->on('features')
                    ->index('feature_values_feature_id_features_id')
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
            Schema::table('features_values', function (Blueprint $table) {
                $table->dropForeign('feature_values_feature_id_features_id');
            });
            Schema::dropIfExists('features_values');
        }
    }

}
