<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrdersStatusesHistoryTranslates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_statuses_history_translates', function (Blueprint $table) {
            $table->increments('id');
    
            $table->string('name');
    
            $table->integer('row_id')->unsigned();
            $table->string('language', 3);
    
            $table->foreign('language')->references('slug')->on('languages')
                ->index('osh_translates_language_languages_slug')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('row_id')->references('id')->on('orders_statuses_history')
                ->index('osh_translates_row_id_osh_id')
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
            Schema::table('orders_statuses_history_translates', function (Blueprint $table) {
                $table->dropForeign('osh_translates_language_languages_slug');
                $table->dropForeign('osh_translates_row_id_osh_id');
            });
            Schema::dropIfExists('orders_statuses_history_translates');
        }
    }
}
