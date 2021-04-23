<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PromUaCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_prom_ua', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned()->nullable();
            $table->integer('prom_ua_id')->index();
            
            $table->foreign('category_id')->references('id')->on('categories')
                ->index('categories_prom_ua_category_id_categories_id')
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
            Schema::table('categories_prom_ua', function (Blueprint $table) {
                $table->dropForeign('categories_prom_ua_category_id_categories_id');
            });
            Schema::drop('categories_prom_ua');
        }
    }
}
